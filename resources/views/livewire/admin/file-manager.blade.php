<div>
    <div class="file-manager-container" 
     x-data="{ 
        showModal: false, 
        isDragging: false, 
        selectedCount: @entangle('selectedFiles').live, 
        copyToClipboard(url) { 
            navigator.clipboard.writeText(url); 
            $dispatch('notify', {type: 'info', message: 'URL copied to clipboard!'}); 
        } 
     }" 
     @show-file-modal.window="showModal = true" 
     @hide-file-modal.window="showModal = false" 
     x-cloak>
    
    <div class="file-manager-wrapper container-fluid px-3">
        <!-- Header Actions -->
        <div class="d-flex flex-wrap justify-content-between align-items-center mb-4 bg-white p-3 rounded-lg shadow-sm border-0 gap-3 mt-3">
            <div class="d-flex align-items-center gap-2">
                <div class="input-group input-group-sm" style="width: 250px;">
                    <div class="input-group-prepend">
                        <span class="input-group-text bg-light border-0"><i class="fas fa-search text-muted"></i></span>
                    </div>
                    <input type="text" wire:model.live.debounce.300ms="search" class="form-control border-0 bg-light" placeholder="Search assets...">
                </div>

                <select wire:model.live="modelFilter" class="form-control form-control-sm border-0 bg-light font-weight-bold ml-2 shadow-none" style="width: 150px;">
                    <option value="all">All Types</option>
                    <option value="App\Models\Project">Projects</option>
                    <option value="App\Models\Team">Team Assets</option>
                </select>
            </div>

            <div class="actions d-flex align-items-center">
                <template x-if="selectedCount && selectedCount.length > 0">
                    <button wire:click="deleteSelected" wire:confirm="Delete selected items?" class="btn btn-sm btn-danger mr-3 shadow-sm animate__animated animate__fadeIn">
                        <i class="fas fa-trash-alt mr-1"></i> Delete (<span x-text="selectedCount.length"></span>)
                    </button>
                </template>
                
                <button class="btn btn-sm shadow-sm px-4 text-white font-weight-bold btn-upload" 
                        style="background: linear-gradient(45deg, #f06, #9f00ff);"
                        @click="showModal = true; $wire.set('editingFileId', null)">
                    <i class="fas fa-plus mr-1"></i> New Asset
                </button>
            </div>
        </div>

        <!-- Loading Skeletons -->
        <div wire:loading.flex wire:target="search, modelFilter, gotoPage" class="row">
            @for($i=0; $i<6; $i++)
                <div class="col-6 col-md-2 mb-4"><div class="skeleton-card" style="height: 150px; background: #eee; border-radius: 10px;"></div></div>
            @endfor
        </div>

        <!-- File Grid -->
        <div wire:loading.remove wire:target="search, modelFilter, gotoPage">
            <div class="row">
                @forelse($fileGroups as $type => $files)
                    <div class="col-12 mt-3 mb-2">
                        <div class="d-flex align-items-center">
                            <span class="badge badge-primary-soft text-uppercase letter-spacing-1 px-3 py-1 mr-3" style="font-size: 0.65rem; background-color: #e7f1ff; color: #007bff;">
                                {{ class_basename($type) }}
                            </span>
                            <div class="flex-grow-1 border-top opacity-1"></div>
                        </div>
                    </div>

                    @foreach($files as $file)
                        <div class="col-6 col-sm-4 col-md-3 col-lg-2 mb-4" wire:key="file-{{ $file->id }}">
                            <div class="card h-100 file-card border-0 shadow-sm {{ in_array($file->id, $selectedFiles) ? 'selected-border' : '' }}" style="transition: transform 0.2s;">
                                <div class="custom-control custom-checkbox position-absolute" style="top: 10px; left: 10px; z-index: 20;">
                                    <input type="checkbox" class="custom-control-input" id="check-{{ $file->id }}" wire:model.live="selectedFiles" value="{{ $file->id }}">
                                    <label class="custom-control-label" for="check-{{ $file->id }}"></label>
                                </div>

                                <div class="file-preview container-overlay position-relative overflow-hidden" style="height: 140px; background: #f8f9fa;">
                                    @if($file->is_image)
                                        <img src="{{ asset('storage/' . $file->file_path) }}" loading="lazy" class="w-100 h-100" style="object-fit: cover;">
                                    @else
                                        <div class="d-flex align-items-center justify-content-center h-100">
                                            <i class="fas {{ $file->icon_data['icon'] ?? 'fa-file' }} fa-3x {{ $file->icon_data['color'] ?? 'text-muted' }}"></i>
                                        </div>
                                    @endif

                                    <div class="file-actions-overlay position-absolute w-100 h-100 d-flex align-items-center justify-content-center" style="top:0; left:0; background: rgba(0,0,0,0.4); opacity: 0; transition: 0.3s;">
                                        <div class="btn-group shadow-lg">
                                            <button @click="copyToClipboard('{{ asset('storage/' . $file->file_path) }}')" class="btn btn-white btn-sm" title="Copy Link">
                                                <i class="fas fa-link"></i>
                                            </button>
                                            <a href="{{ asset('storage/' . $file->file_path) }}" target="_blank" class="btn btn-white btn-sm" title="View">
                                                <i class="fas fa-eye text-primary"></i>
                                            </a>
                                            <button wire:click="edit({{ $file->id }})" class="btn btn-white btn-sm" title="Edit">
                                                <i class="fas fa-pen text-success"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <span class="position-absolute badge badge-dark opacity-75 small" style="bottom: 5px; right: 5px; font-size: 0.6rem;">
                                        {{ $file->readable_size ?? '' }}
                                    </span>
                                </div>

                                <div class="card-body p-2 bg-white border-top">
                                    <p class="mb-0 text-truncate font-weight-bold small text-dark" title="{{ $file->caption }}">{{ $file->caption }}</p>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <span class="text-muted text-uppercase" style="font-size: 0.55rem; letter-spacing: 0.5px;">{{ pathinfo($file->file_path, PATHINFO_EXTENSION) }}</span>
                                        <span class="text-muted" style="font-size: 0.55rem;">{{ $file->created_at->format('M d, Y') }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @empty
                    <div class="col-12 text-center py-5">
                        <i class="fas fa-folder-open fa-4x text-light mb-3"></i>
                        <h5 class="text-muted font-weight-light">No Assets Found</h5>
                    </div>
                @endforelse
            </div>
        </div>

        <!-- Modal -->
        <div x-show="showModal" class="modal-backdrop-custom" 
             style="position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); z-index: 1050; display: flex; align-items: center; justify-content: center;"
             @click.self="showModal = false" x-transition.opacity>
            
            <div class="modal-dialog modal-dialog-centered shadow-lg animate__animated animate__zoomIn animate__faster" style="width: 100%; max-width: 500px;">
                <div class="modal-content border-0 rounded-xl overflow-hidden" style="border-radius: 15px; background: #fff;">
                    <form wire:submit.prevent="save">
                        <div class="modal-header border-0 bg-light px-4 pt-4 d-flex justify-content-between">
                            <h6 class="modal-title font-weight-bold text-dark">
                                {!! $editingFileId ? '<i class="fas fa-edit mr-2 text-primary"></i>Edit Asset' : '<i class="fas fa-cloud-upload-alt mr-2 text-primary"></i>Upload Asset' !!}
                            </h6>
                            <button type="button" class="close border-0 bg-transparent" @click="showModal = false" style="font-size: 1.5rem;">&times;</button>
                        </div>
                        
                        <div class="modal-body p-4">
                            @if(!$editingFileId)
                                <div class="upload-area p-5 text-center border-dashed rounded-lg" 
                                     style="border: 2px dashed #ddd; cursor: pointer;"
                                     :class="isDragging ? 'bg-light border-primary' : ''"
                                     @dragover.prevent="isDragging = true"
                                     @dragleave.prevent="isDragging = false"
                                     @drop.prevent="isDragging = false"
                                     onclick="document.getElementById('fileInput').click()">
                                    
                                    <input type="file" wire:model="file" id="fileInput" class="d-none">
                                    
                                    <div wire:loading.remove wire:target="file">
                                        <i class="fas fa-file-import fa-3x text-primary opacity-50 mb-3"></i>
                                        <p class="mb-1 font-weight-bold text-dark">Click to browse or drop here</p>
                                        <p class="text-muted small mb-0">Up to 20MB</p>
                                    </div>

                                    <div wire:loading wire:target="file">
                                        <div class="spinner-border text-primary" role="status"></div>
                                        <p class="mt-2 small">Uploading...</p>
                                    </div>
                                </div>
                                @error('file') <div class="text-danger small mt-2"><strong>{{ $message }}</strong></div> @enderror
                            @endif

                            <div class="form-group mt-4">
                                <label class="small text-uppercase font-weight-bold text-muted mb-2">Asset Caption</label>
                                <input type="text" wire:model="caption" class="form-control form-control-lg border-0 bg-light shadow-none rounded-pill px-4" placeholder="Enter name...">
                                @error('caption') <span class="text-danger small"><strong>{{ $message }}</strong></span> @enderror
                            </div>
                        </div>

                        <div class="modal-footer border-0 bg-light px-4 pb-4">
                            <button type="button" class="btn btn-link text-muted font-weight-bold text-decoration-none" @click="showModal = false">Cancel</button>
                            <button type="submit" class="btn btn-primary px-5 shadow rounded-pill font-weight-bold" wire:loading.attr="disabled">
                                {{ $editingFileId ? 'Update Asset' : 'Save Asset' }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</div>