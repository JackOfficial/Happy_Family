<div class="file-manager-wrapper" x-data="{ showModal: false, selectedCount: @entangle('selectedFiles').live }" x-cloak>
    <div class="container-fluid px-3">
        <div class="d-flex justify-content-between align-items-center mb-4 bg-white p-3 rounded shadow-sm border-0">
            <div class="d-flex align-items-center">
                <div class="input-group input-group-sm mr-2" style="width: 200px;">
                    <div class="input-group-prepend">
                        <span class="input-group-text bg-light border-0"><i class="fas fa-filter text-muted"></i></span>
                    </div>
                    <select wire:model.live="modelFilter" class="form-control border-0 bg-light font-weight-bold">
                        <option value="all">All Media</option>
                        <option value="App\Models\Project">Projects</option>
                        <option value="App\Models\Team">Team Assets</option>
                    </select>
                </div>
                <span class="badge badge-pill badge-light border px-3 py-2 text-muted small">{{ $totalCount }} Items</span>
            </div>

            <div class="actions">
                <template x-if="selectedCount && selectedCount.length > 0">
                    <button wire:click="deleteSelected" wire:confirm="Delete selected items?" class="btn btn-sm btn-outline-danger mr-2 px-3">
                        <i class="fas fa-trash-alt mr-1"></i> Delete (<span x-text="selectedCount.length"></span>)
                    </button>
                </template>
                <button class="btn btn-sm shadow-sm px-4 text-white" @click="showModal = true; $wire.set('editingFileId', null)" style="background-color: #e83e8c; border-radius: 20px;">
                    <i class="fas fa-cloud-upload-alt mr-1"></i> Upload Asset
                </button>
            </div>
        </div>

        <div class="row">
            @forelse($fileGroups as $type => $files)
                <div class="col-12 mt-4 mb-2">
                    <div class="d-flex align-items-center">
                        <h6 class="text-uppercase font-weight-bold text-secondary mb-0" style="font-size: 0.7rem; letter-spacing: 1px;">
                            {{ class_basename($type) }}
                        </h6>
                        <div class="flex-grow-1 ml-3 border-top opacity-25"></div>
                    </div>
                </div>

                @foreach($files as $file)
                    <div class="col-6 col-sm-4 col-md-3 col-lg-2 mb-4" wire:key="file-{{ $file->id }}">
                        <div class="card h-100 file-card border-0 shadow-sm {{ in_array($file->id, $selectedFiles) ? 'border-primary' : '' }}" style="border-radius: 12px; overflow: hidden; position: relative;">
                            
                            <div class="position-absolute" style="top: 8px; left: 8px; z-index: 10;">
                                <input type="checkbox" wire:model.live="selectedFiles" value="{{ $file->id }}">
                            </div>

                            <div class="file-preview bg-light d-flex align-items-center justify-content-center" style="height: 140px; position: relative;">
                                @if($file->is_image)
                                    <img src="{{ asset('storage/' . $file->file_path) }}" class="w-100 h-100" style="object-fit: cover;">
                                @else
                                    <i class="fas {{ $file->icon_data['icon'] }} fa-3x {{ $file->icon_data['color'] }}"></i>
                                @endif

                                <div class="file-overlay">
                                    <div class="btn-group btn-group-sm shadow">
                                        <a href="{{ asset('storage/' . $file->file_path) }}" target="_blank" class="btn btn-white btn-sm"><i class="fas fa-eye text-primary"></i></a>
                                        <button wire:click="edit({{ $file->id }})" class="btn btn-white btn-sm"><i class="fas fa-pen text-success"></i></button>
                                    </div>
                                </div>
                            </div>

                            <div class="card-body p-2 border-top bg-white">
                                <p class="mb-0 text-truncate font-weight-bold small text-dark" title="{{ $file->caption }}">{{ $file->caption }}</p>
                            </div>
                        </div>
                    </div>
                @endforeach
            @empty
                <div class="col-12 text-center py-5">
                    <i class="fas fa-images fa-3x text-light mb-3"></i>
                    <p class="text-muted">No files found.</p>
                </div>
            @endforelse
        </div>

        <div x-show="showModal" class="modal" :class="{ 'd-block': showModal }" style="background: rgba(0,0,0,0.5); z-index: 1050;" @click.self="showModal = false">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content border-0 shadow-lg" style="border-radius: 15px;">
                    <form wire:submit.prevent="save">
                        <div class="modal-header border-0 pb-0">
                            <h5 class="modal-title font-weight-bold">{{ $editingFileId ? 'Edit Asset' : 'New Asset' }}</h5>
                            <button type="button" class="close" @click="showModal = false">&times;</button>
                        </div>
                        <div class="modal-body p-4">
                            @if(!$editingFileId)
                                <div class="upload-zone border-dashed rounded p-4 text-center mb-3 bg-light" 
                                     style="border: 2px dashed #dee2e6; cursor: pointer;" 
                                     onclick="document.getElementById('fileInput').click()">
                                    <i class="fas fa-cloud-upload-alt fa-2x text-primary mb-2"></i>
                                    <p class="small font-weight-bold mb-0">Click to Select File</p>
                                    <input type="file" wire:model="file" id="fileInput" class="d-none">
                                    <div wire:loading wire:target="file" class="mt-2 text-primary small">
                                        <div class="spinner-border spinner-border-sm mr-1"></div> Uploading...
                                    </div>
                                </div>
                            @endif
                            <div class="form-group">
                                <label class="small text-uppercase font-weight-bold text-muted">Caption</label>
                                <input type="text" wire:model="caption" class="form-control border-0 bg-light shadow-sm">
                            </div>
                        </div>
                        <div class="modal-footer border-0">
                            <button type="button" class="btn btn-link text-muted" @click="showModal = false">Cancel</button>
                            <button type="submit" class="btn text-white px-4 shadow-sm" style="background-color: #e83e8c; border-radius: 8px;">Save Asset</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>