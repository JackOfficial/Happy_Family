<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Photo; // You might want to rename this Model to 'Media' later
use Illuminate\Support\Facades\Storage;
use Livewire\WithPagination;

class FileManager extends Component
{
    use WithFileUploads, WithPagination;

    public $file;
    public $caption;
    public $editingFileId = null;
    public $selectedFiles = [];
    public $modelFilter = 'all';
    
    // Supported file types for the professional UI
    protected $imageExtensions = ['jpg', 'jpeg', 'png', 'gif', 'webp', 'svg'];
    protected $documentExtensions = ['pdf', 'doc', 'docx', 'xls', 'xlsx', 'txt', 'zip'];

    protected $paginationTheme = 'bootstrap';

    /**
     * Rules updated to allow various document types
     */
    protected function rules()
    {
        return [
            'file' => $this->editingFileId ? 'nullable|max:10240' : 'required|max:10240', // 10MB Limit
            'caption' => 'nullable|string|max:255',
        ];
    }

    public function updatedModelFilter()
    {
        $this->resetPage();
    }

    public function save()
    {
        $this->validate();

        if ($this->editingFileId) {
            $media = Photo::findOrFail($this->editingFileId);
            
            if ($this->file) {
                Storage::disk('public')->delete($media->file_path);
                $media->file_path = $this->file->store('uploads', 'public');
            }
            
            $media->caption = $this->caption;
            $media->save();
            session()->flash('message', 'File updated successfully.');
        } else {
            $path = $this->file->store('uploads', 'public');
            
            Photo::create([
                'file_path' => $path,
                'caption' => $this->caption ?? $this->file->getClientOriginalName(),
                'imageable_type' => $this->modelFilter === 'all' ? 'App\Models\General' : $this->modelFilter,
                'imageable_id' => 0, 
            ]);

            session()->flash('message', 'File uploaded successfully.');
        }

        $this->reset(['file', 'caption', 'editingFileId']);
        $this->dispatch('hide-file-modal'); // JS to close modal
    }

    public function edit($id)
    {
        $media = Photo::findOrFail($id);
        $this->editingFileId = $id;
        $this->caption = $media->caption;
        $this->file = null;
        $this->dispatch('show-file-modal'); 
    }

    public function delete($id)
    {
        $media = Photo::find($id);
        if ($media) {
            Storage::disk('public')->delete($media->file_path);
            $media->delete();
            session()->flash('message', 'File removed.');
        }
    }

    public function deleteSelected()
    {
        $files = Photo::whereIn('id', $this->selectedFiles)->get();
        foreach ($files as $file) {
            Storage::disk('public')->delete($file->file_path);
            $file->delete();
        }
        $this->selectedFiles = [];
        session()->flash('message', 'Selected files deleted.');
    }

    /**
     * Helper to get icon based on extension
     */
    private function getFileIcon($path)
    {
        $ext = strtolower(pathinfo($path, PATHINFO_EXTENSION));
        return match($ext) {
            'pdf' => ['icon' => 'fa-file-pdf', 'color' => 'text-danger'],
            'doc', 'docx' => ['icon' => 'fa-file-word', 'color' => 'text-primary'],
            'xls', 'xlsx' => ['icon' => 'fa-file-excel', 'color' => 'text-success'],
            'zip', 'rar' => ['icon' => 'fa-file-archive', 'color' => 'text-warning'],
            default => ['icon' => 'fa-file-alt', 'color' => 'text-secondary'],
        };
    }

   public function render()
{
    $query = Photo::query();
    
    if ($this->modelFilter !== 'all') {
        $query->where('imageable_type', $this->modelFilter);
    }

    $allFiles = $query->latest()->paginate(24); 
    
    // Group and inject metadata for the UI
    $grouped = collect($allFiles->items())->groupBy('imageable_type')->map(function ($items) {
        return $items->map(function($item) {
            $ext = strtolower(pathinfo($item->file_path, PATHINFO_EXTENSION));
            
            // Check if it's an image
            $item->is_image = in_array($ext, $this->imageExtensions);
            $item->extension = $ext;
            
            // If it's NOT an image, get the professional icon data
            $item->icon_data = $item->is_image ? null : $this->getFileIcon($item->file_path);
            
            return $item;
        });
    });

    return view('livewire.admin.file-manager', [
        'fileGroups' => $grouped,
        'files' => $allFiles,
        'totalCount' => $allFiles->total(),
    ]);
}
}