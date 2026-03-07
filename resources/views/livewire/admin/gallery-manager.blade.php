<div class="mx-3">
    <div class="row align-items-center mb-4 bg-white p-3 rounded shadow-sm border-left border-primary">
        <div class="col-md-6 d-flex align-items-center gap-3">
            <div class="input-group input-group-sm w-auto">
                <label class="input-group-text bg-light border-0" for="modelFilter"><i class="fas fa-filter text-muted"></i></label>
                <select wire:model.live="modelFilter" id="modelFilter" class="form-select border-0 shadow-none font-weight-bold">
                    <option value="all">All Categories</option>
                    <option value="App\Models\Project">Projects</option>
                    <option value="App\Models\Team">Team Members</option>
                    <option value="App\Models\Event">Events</option>
                </select>
            </div>
            <span class="badge badge-pill badge-light border px-3 py-2 text-dark">
                {{ $totalPhotos }} <span class="text-muted font-weight-normal ml-1">Images Total</span>
            </span>
        </div>

        <div class="col-md-6 text-right d-flex justify-content-end gap-2">
            @if(count($selectedPhotos) > 0)
                <button wire:click="deleteSelected" 
                        wire:confirm="Are you sure you want to delete {{ count($selectedPhotos) }} photos?"
                        class="btn btn-sm btn-outline-danger shadow-sm px-3">
                    <i class="fas fa-trash-alt mr-1"></i> Delete Selected ({{ count($selectedPhotos) }})
                </button>
            @endif

            <button class="btn btn-sm btn-primary shadow-sm px-4 py-2" data-toggle="modal" data-target="#photoModal" wire:click="resetForm">
                <i class="fas fa-plus mr-1"></i> Add New Media
            </button>
        </div>
    </div>

    <div wire:loading wire:target="modelFilter" class="text-center py-4 w-100">
        <div class="spinner-border spinner-border-sm text-primary" role="status"></div>
        <span class="ml-2 text-muted">Filtering gallery...</span>
    </div>

    @if (session()->has('message'))
        <div class="alert alert-success border-0 shadow-sm alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle mr-2"></i> {{ session('message') }}
            <button type="button" class="close" data-dismiss="alert">&times;</button>
        </div>
    @endif

    @if(empty($photoGroups) || count($photoGroups) === 0)
        <div class="card border-0 shadow-sm py-5 text-center">
            <i class="fas fa-images fa-4x text-light mb-3"></i>
            <h5 class="text-muted">Your gallery is empty</h5>
            <p class="small text-secondary">Start by adding photos to your projects or events.</p>
        </div>
    @else
        @foreach($photoGroups as $modelName => $group)
            <div class="mb-5">
                <h5 class="font-weight-bold text-dark border-bottom pb-2 mb-3">
                    <i class="fas fa-folder-open text-primary mr-2"></i> 
                    {{ class_basename($modelName) }} 
                    <small class="text-muted font-weight-normal">({{ $group->count() }} items)</small>
                </h5>
                
                <div class="row g-4">
                    @foreach($group as $photo)
                        <div class="col-xl-2 col-lg-3 col-md-4 col-sm-6 mb-4">
                            <div class="card photo-card border-0 h-100 {{ in_array($photo->id, $selectedPhotos) ? 'selected-card' : '' }}">
                                <div class="custom-control custom-checkbox selection-overlay">
                                    <input type="checkbox" wire:model.live="selectedPhotos" value="{{ $photo->id }}" class="custom-control-input" id="check-{{ $photo->id }}">
                                    <label class="custom-control-label" for="check-{{ $photo->id }}"></label>
                                </div>

                                <img src="{{ asset('storage/' . $photo->file_path) }}" 
                                     class="card-img rounded shadow-sm" 
                                     loading="lazy">

                                <div class="photo-info p-2">
                                    <div class="d-flex justify-content-between align-items-start">
                                        <p class="mb-0 small font-weight-bold text-truncate" title="{{ $photo->caption }}">
                                            {{ $photo->caption ?? 'Untitled' }}
                                        </p>
                                        <div class="dropdown">
                                            <i class="fas fa-ellipsis-v text-muted px-1 cursor-pointer" data-toggle="dropdown"></i>
                                            <div class="dropdown-menu dropdown-menu-right shadow border-0">
                                                <button class="dropdown-item py-2" wire:click="edit({{ $photo->id }})" data-toggle="modal" data-target="#photoModal">
                                                    <i class="fas fa-edit mr-2 text-info"></i> Edit Caption
                                                </button>
                                                <div class="dropdown-divider"></div>
                                                <button class="dropdown-item py-2 text-danger" wire:click="delete({{ $photo->id }})" wire:confirm="Remove this photo?">
                                                    <i class="fas fa-trash mr-2"></i> Delete Photo
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    <span class="x-small text-muted">{{ $photo->created_at->format('M d, Y') }}</span>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endforeach
    @endif

    <div wire:ignore.self class="modal fade shadow" id="photoModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0">
                <form wire:submit.prevent="save">
                    <div class="modal-header border-0 bg-light">
                        <h5 class="modal-title font-weight-bold">
                            {{ $editingPhotoId ? 'Update Photo Information' : 'Add New Media' }}
                        </h5>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body p-4">
                        @if(!$editingPhotoId)
                        <div class="form-group mb-3">
                            <label class="small font-weight-bold">Select File</label>
                            <div class="custom-file">
                                <input type="file" wire:model="file" class="custom-file-input" id="galleryUpload">
                                <label class="custom-file-label" for="galleryUpload">Choose image...</label>
                            </div>
                            <div wire:loading wire:target="file" class="mt-2 small text-primary">
                                <i class="fas fa-spinner fa-spin mr-1"></i> Uploading to server...
                            </div>
                            @error('file') <div class="text-danger x-small mt-1">{{ $message }}</div> @enderror
                        </div>
                        @endif

                        <div class="form-group mb-0">
                            <label class="small font-weight-bold">Caption / Label</label>
                            <input type="text" wire:model="caption" class="form-control" placeholder="Describe this photo...">
                        </div>
                    </div>
                    <div class="modal-footer border-0 bg-light">
                        <button type="button" class="btn btn-link text-muted" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary px-4 shadow-sm" wire:loading.attr="disabled">
                            <i class="fas fa-save mr-1"></i> {{ $editingPhotoId ? 'Update' : 'Start Upload' }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <style>
        .photo-card {
            transition: all 0.25s ease;
            background: #fdfdfd;
            border-radius: 12px;
            cursor: default;
        }
        .photo-card img {
            width: 100%;
            height: 180px;
            object-fit: cover;
            border-bottom-left-radius: 0;
            border-bottom-right-radius: 0;
        }
        .photo-card:hover { transform: translateY(-4px); box-shadow: 0 12px 20px rgba(0,0,0,0.1) !important; }
        .selected-card { border: 2px solid #007bff !important; background-color: #f0f7ff; }
        
        .selection-overlay {
            position: absolute;
            top: 10px;
            left: 10px;
            z-index: 5;
            background: rgba(255,255,255,0.8);
            padding: 2px 5px 2px 18px;
            border-radius: 20px;
            backdrop-filter: blur(2px);
        }

        .x-small { font-size: 0.75rem; }
        .cursor-pointer { cursor: pointer; }
        .dropdown-item { font-size: 0.85rem; }
        
        /* Custom Checkbox Alignment Fix */
        .custom-control-label::before, .custom-control-label::after { top: 0.15rem; }
    </style>
</div>