<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Photo;
use Illuminate\Support\Facades\Storage;
use Livewire\WithPagination;

class FileManager extends Component
{
    use WithFileUploads, WithPagination;

    public $file;
    public $caption;
    public $search = '';
    public $editingFileId = null;
    public $selectedFiles = [];
    public $modelFilter = 'all';
    
    protected $imageExtensions = ['jpg', 'jpeg', 'png', 'gif', 'webp', 'svg'];
    protected $paginationTheme = 'bootstrap';

    protected function rules() {
        return [
            'file' => $this->editingFileId ? 'nullable|max:20480' : 'required|max:20480', // 20MB
            'caption' => 'nullable|string|max:255',
        ];
    }

    public function updatedSearch() { $this->resetPage(); }
    public function updatedModelFilter() { $this->resetPage(); }

   public function save()
{
    $this->validate();

    if ($this->editingFileId) {
        $media = Photo::findOrFail($this->editingFileId);
        
        if ($this->file) {
            // Delete old physical file
            Storage::disk('public')->delete($media->file_path);
            
            // Store new file and capture metadata
            $media->file_path = $this->file->store('uploads', 'public');
            $media->file_size = $this->file->getSize();
            $media->file_type = $this->file->getMimeType();
        }
        
        $media->caption = $this->caption;
        $media->save();
        
        $this->dispatch('notify', [
            'type' => 'success', 
            'message' => 'Asset updated successfully!'
        ]);
        
    } else {
        // New Upload
        $path = $this->file->store('uploads', 'public');
        
        Photo::create([
            'file_path' => $path,
            'file_size' => $this->file->getSize(),
            'file_type' => $this->file->getMimeType(),
            'caption' => $this->caption ?: $this->file->getClientOriginalName(),
            'imageable_type' => $this->modelFilter === 'all' ? 'App\Models\General' : $this->modelFilter,
            'imageable_id' => 0, 
        ]);

        $this->dispatch('notify', [
            'type' => 'success', 
            'message' => 'New asset uploaded successfully!'
        ]);
    }

    // Reset UI state
    $this->reset(['file', 'caption', 'editingFileId']);
    
    // Close the Alpine.js modal
    $this->dispatch('hide-file-modal');
}

    public function edit($id)
    {
        $media = Photo::findOrFail($id);
        $this->editingFileId = $id;
        $this->caption = $media->caption;
        $this->file = null;
        $this->dispatch('show-file-modal'); 
    }

    public function deleteSelected()
    {
        $files = Photo::whereIn('id', $this->selectedFiles)->get();
        foreach ($files as $file) {
            Storage::disk('public')->delete($file->file_path);
            $file->delete();
        }
        $this->selectedFiles = [];
        $this->dispatch('notify', ['type' => 'error', 'message' => 'Items Deleted']);
    }

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
    $query = Photo::query()
        ->when($this->modelFilter !== 'all', 
            fn($q) => $q->where('imageable_type', $this->modelFilter)
        )
        ->when($this->search, 
            fn($q) => $q->where('caption', 'like', '%' . $this->search . '%')
        );

    // 1. Execute pagination (This object has the ->links() method)
    $allFiles = $query->latest()->paginate(18); 

    // 2. Transform the items into groups for the UI
    // We use ->getCollection() to manipulate the items without breaking the paginator
    $grouped = collect($allFiles->items())->groupBy('imageable_type')->map(function ($items) {
        return $items->map(function($item) {
            $ext = strtolower(pathinfo($item->file_path, PATHINFO_EXTENSION));
            
            // UI Helpers
            $item->is_image = in_array($ext, $this->imageExtensions);
            $item->icon_data = $item->is_image ? null : $this->getFileIcon($item->file_path);
            
            // Human-readable file size (converts bytes to KB/MB)
            if ($item->file_size) {
                $item->readable_size = $item->file_size >= 1048576 
                    ? number_format($item->file_size / 1048576, 2) . ' MB' 
                    : number_format($item->file_size / 1024, 1) . ' KB';
            } else {
                $item->readable_size = '0 KB';
            }
            
            return $item;
        });
    });

    return view('livewire.admin.file-manager', [
        'fileGroups' => $grouped,    // Used for the @foreach grouping in Blade
        'files' => $allFiles,         // Used for {{ $files->links() }}
        'totalCount' => $allFiles->total(),
    ]);
}
}