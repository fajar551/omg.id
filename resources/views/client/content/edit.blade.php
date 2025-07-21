@extends('layouts.template-body')

@section('title')
    <title>@lang('Edit Content')</title>
@endsection

@section('styles')
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.13.5/css/selectize.bootstrap5.min.css" />
    <style>
    </style>
@endsection

@section('content')
    <div class="container px-5 ">
        <div class="row">
            <div class="col-12">
                @include('components.breadcrumb', [
                    'title' => __('Edit Konten'), 
                    'pages' => [
                        route('content.index')  => __('Konten'),
                        '#' => __('Edit'),
                    ]
                ])
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                @include('components.flash-message', ['flashName' => 'message'])
            </div>
        </div>

        <form action="{{ route('content.update') }}" method="POST" class="needs-validation" id="form-content" enctype="multipart/form-data" onsubmit="doSubmit($('#dropdownSubmit'))" autocomplete="off">
            @csrf
            @method('PUT')
            <input type="number" name="id" id="id" value="{{ $content->id }}" hidden required>
            <input type="number" name="status" id="status" value="{{ old('status', $content->status) }}" hidden>
            <input type="text" name="body" id="body" value="{{ old('body', json_encode($content->body)) }}" hidden>
            <input type="text" name="tempUploadedImage" id="tempUploadedImage" hidden>
            <div class="row mb-5 ">
                <div class="col-lg-8 mb-3 ">
                    <div class="card border-0 shadow rounded-small min-vh-100 card-dark">
                        <div class="card-body">
                            <div class="px-2 rounded mb-3">
                                <span class="text-sm text-muted">TOPIC</span>
                                <textarea name="title" id="content-title" class="form-control mb-4 card-dark @error('title') is-invalid @enderror" placeholder="Judul Konten" rows="2" autocomplete="off" required spellcheck="false" style="overflow: hidden;">{{ old('title', $content->title) }}</textarea>
                                @error('title')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div id="editorjs" spellcheck="false" class="ps-3 pe-3 rounded"></div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-sm-12">
                    <div class="card border-0 py-2 rounded-small shadow min-vh-100 card-dark">
                        <div class="card-body">
                            <div class="d-flex flex-column ">
                                <div class="form-group mb-3">
                                    <label for="attachment" class="form-label d-block fw-bold">@lang('Downloadable File')</label>
                                    <span class="btn border-0 btn-file w-100 p-0" title="File Attachment">
                                        <div class=" p-1 text-center rounded" style="background-color: #F1FABE !important;" id="attachment-div">
                                            <small style="color: #869B0F;">Browse for attachment</small>
                                            <br>
                                        </div>
                                        <input type="file" name="attachment" id="attachment">
                                    </span>
                                    <small>*) Max: 15mb</small><br>
                                    <small class="text-left" id="attachment_info">
                                        @if ($content->file)
                                            @php
                                                $fileInfo = pathinfo($content->file);
                                                $displayName = substr($fileInfo['basename'], 0, 15)  ."..._." .$fileInfo['extension'];
                                            @endphp
                                            <a href="{{ route('content.download', ['id' => $content->id]) }}" class="text-dark">{{ $displayName }} <i class="fas fa-download text-primary"></i></a>
                                        @endif
                                    </small> 
                                    @error('attachment')
                                        {{-- Input trick to display invalid-feedback --}}
                                        <input type="file" class="@error('attachment') is-invalid @enderror" hidden>
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group mb-3">
                                    <label for="external_link" class="form-label d-block fw-bold">@lang('External Link')</label>
                                    <input type="url" name="external_link" id="external_link" class="form-control @error('external_link') is-invalid @enderror" placeholder="https://your-external-link" value="{{ old('external_link', $content->external_link) }}" autocomplete="off">
                                    @error('external_link')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                {{-- <div class="form-group mb-3">
                                    <label for="category_id" class="form-label d-block fw-bold">@lang('Kategori') <span class="text-danger" title="Bidang ini dibutuhkan">*</span></label>
                                    <div class="input-group">
                                        <select name="category_id" id="category_id" class="form-select @error('category_id') is-invalid @enderror" required>
                                        </select>
                                        <span class="input-group-text bg-danger">
                                            <button type="button" id="btn-add-category" class="btn btn-transparent btn-sm p-0 me-1" title="Buat Kategori Baru"><i class="fas fa-plus"></i></button>
                                            <button type="button" id="btn-remove-category" class="btn btn-transparent btn-sm p-0" title="Hapus Kategori Ini"><i class="fas fa-minus text-danger"></i></button>
                                        </span>
                                        @error('category_id')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div> --}}
                                <div class="form-group mb-3">
                                    <label class="form-label d-block fw-bold">@lang('Kategori') <span class="text-danger" title="Bidang ini dibutuhkan">*</span></label>
                                    <div class="input-group">
                                        <select name="category_id" id="select-category" class="demo-default form-control @error('category_id') is-invalid @enderror" placeholder="Buat atau pilih kategori" required>
                                            @foreach($categories as $category)
                                                <option value="{{ $category->id }}" @if($category->id == old('category_id', $content->category_id)) selected @endif>{{ $category->title }}</option>
                                            @endforeach
                                        </select>
                                        <span class="input-group-text bg-transparent">
                                            <button type="button" id="btn-remove-category" class="btn btn-transparent btn-sm p-0" title="Hapus Kategori Ini"><i class="fas fa-times text-danger"></i></button>
                                        </span>
                                        @error('category_id')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group mb-3">
                                    <label for="external_link" class="form-label d-block fw-bold">@lang('Thumbnail')</label>
                                    <div class="">
                                        <div class="d-flex align-items-center">
                                            <img class="img-fluid thumb-content-preview rounded-top-small border" id="thumbnail-preview" src="{{ $content->thumbnail_path ?? asset('template/images/content_thumbnail.png') }}" alt="Cover Image">
                                        </div>
                                        <input type="file" name="thumbnail" id="thumbnail" class="form-control-sm py-2 px-3 border rounded-xsmall w-100 @error('thumbnail') is-invalid @enderror" accept="image/*" >
                                        @error('thumbnail')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <small>*) jpg, jpeg, png, max: 2mb, recommended size 280x109px.</small>
                                </div>
                                <div class="form-group mb-3">
                                    <label class="form-label d-block fw-bold">@lang('Item Dukungan')</label>
                                    @if ($activeItem)
                                    <input type="number" name="item_id" value="{{ $activeItem['id'] }}" hidden>
                                    <div class="input-group ">
                                        <span class="input-group-text bg-transparent" id="basic-addon1">
                                            <img src="{{ $activeItem['icon'] }}" class="img-fluid icon-25" alt="Item Icon" title="{{ $activeItem['name'] }}" style="object-fit: cover;">
                                        </span>
                                        <input type="number" name="qty" id="item-qty" class="form-control @error('qty') is-invalid @enderror" min="0" max="100" value="{{ old('qty', $content->qty) }}" aria-describedby="basic-addon1">
                                    </div>
                                    @endif
                                    <div class="bg-info py-1 text-center rounded-bottom-xsmall">
                                        <small id="qty-sum">Free</small>
                                    </div>
                                    @error('qty')
                                        {{-- Input trick to display invalid-feedback --}}
                                        <input type="number" class="@error('qty') is-invalid @enderror" hidden>
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <hr>
                            <p class="text-center mt-5">
                                Dengan menerbitkan konten ini, Anda telah menyetujui <a href="{{ route('pages.termofservice') }}" target="_blank" class="text-primary">Syarat dan Ketentuan </a> OMG.ID.
                            </p>
                            <div class="dropdown ">
                                <button class="btn btn-primary d-block w-100 rounded-pill mb-3 dropdown-toggle" type="button" id="dropdownSubmit" data-bs-toggle="dropdown" aria-expanded="false">
                                    @lang('Simpan')
                                </button>
                                <ul class="dropdown-menu bg-white border-1 shadow rounded-small" aria-labelledby="dropdownSubmit">
                                    <li><button type="button" class="dropdown-item" id="btn-save-draft"><i class="fas fa-save"></i>  Draft</button></li>
                                    <li><button type="button" class="dropdown-item" id="btn-save-publish"><i class="fas fa-paper-plane"></i> Publish</button></li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li><a href="javascript:void(0);" data-id="{{ $content->id }}" class="dropdown-item text-danger btn-delete"><i class="fas fa-trash"></i> Delete</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
        <form action="{{ route('content.delete') }}" method="POST" id="delete-form" hidden>
            @csrf
            @method("DELETE")
            <input type="hidden" name="id" id="delete-id" value="{{ $content->id }}" required />
        </form>
    </div>

    <!-- Start modal add kategori -->
    <div class="modal fade" id="addCategoryModal" tabindex="-1" role="dialog" aria-labelledby="addcategoryModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addcategoryModalLabel">@lang('Buat Kategori Baru')</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="" method="POST" class="mt-2 needs-validation" id="form-addCategory" enctype="multipart/form-data" autocomplete="off">
                    <div class="modal-body">
                        @csrf
                        <div class="row">
                            <div class="form-group">
                                <label for="title" class="form-label"> @lang('Kategori') <span class="text-danger">*</span></label>
                                <input type="text" name="title" id="title" class="form-control input-title notif" list="category_sugestion" placeholder="Contoh: Design, Blogging, Art dll" required>
                                <datalist id="category_sugestion" >
                                    @foreach ($defaultCategory as $category)
                                        <option value="{{ $category }}">{{ $category }}</option>
                                    @endforeach
                                </datalist>
                                <div class="invalid-feedback text-danger error-title"></div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" id="btn-addCategory-submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- End modal add category -->
@endsection

@section('scripts')
    <script src="{{ asset('template/js/jquery.fontselect.min.js') }}"></script>
    <script src="{{ asset('assets/js/utils.js') }}"></script>
    <script src="{{ asset('assets/js/alert.js') }}"></script>
    <script src="{{ asset('template/vendor/editorjs/editor.js') }}"></script>
    <script src="{{ asset('template/vendor/editorjs/ext/header-2.6.2.min.js') }}"></script>
    <script src="{{ asset('template/vendor/editorjs/ext/paragraph-2.8.0.min.js') }}"></script>
    <script src="{{ asset('template/vendor/editorjs/ext/image-2.6.2.min.js') }}"></script>
    <script src="{{ asset('template/vendor/editorjs/ext/simple-image-1.4.1.min.js') }}"></script>
    <script src="{{ asset('template/vendor/editorjs/ext/list-1.7.0.min.js') }}"></script>
    <script src="{{ asset('template/vendor/editorjs/ext/nested-list-1.0.2.min.js') }}"></script>
    <script src="{{ asset('template/vendor/editorjs/ext/checklist-1.3.0.min.js') }}"></script>
    <script src="{{ asset('template/vendor/editorjs/ext/link-2.4.1.min.js') }}"></script>
    <script src="{{ asset('template/vendor/editorjs/ext/delimiter-1.2.0.min.js') }}"></script>
    <script src="{{ asset('template/vendor/editorjs/ext/code-2.7.0.min.js') }}"></script>
    <script src="{{ asset('template/vendor/editorjs/ext/inline-code-1.3.1.min.js') }}"></script>
    <script src="{{ asset('template/vendor/editorjs/ext/marker-1.2.2.min.js') }}"></script>
    <script src="{{ asset('template/vendor/editorjs/ext/quote-2.4.0.min.js') }}"></script>
    <script src="{{ asset('template/vendor/editorjs/ext/embed-2.5.1.min.js') }}"></script>
    <script src="{{ asset('template/vendor/editorjs/ext/paragraph-with-alignment-3.0.1.min.js') }}"></script>
    <script src="{{ asset('template/vendor/editorjs/ext/editorjs-alert-1.0.3.min.js') }}"></script>
    <script src="{{ asset('template/vendor/serialize-json/jquery.serializejson.min.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.13.5/js/standalone/selectize.min.js"></script>

    <script>
        /**
        * Manage content edit script
        * Version: 1.0
        */
        (function ($) {
            "use strict";

            const metaUrl = "{{ route('content.meta') }}";
            let tempUploadedImage = [];
            let defaultCategory = [];
            let editor = null;
            let $select = null;
            let selectizeInstance = null;

            $(() => {
                $select = $("#select-category").selectize({
                    // plugins: ["remove_button"],
                    sortField: "text",
                    create: function (input, callback) {
                        const formData = new FormData();
                        formData.append('_token', '{{ csrf_token() }}');
                        formData.append('title', input);

                        this.disable();
                        axios.post(`/api/contentcategory/create`, formData)
                            .then(({ data }) => {
                                const { message = 'Success' } = data;
                                const category = data.data;

                                callback({
                                    value: category.id,
                                    text: category.title,
                                });
                            }).catch(({ response: { data } }) => {
                                const { message = 'Error!', errors = {} } = data;

                                Toast2.fire({ 
                                    icon: 'error', 
                                    title: message,
                                    html: handleAjaxError(errors)
                                });

                                callback();
                            }).finally(() => {
                                this.enable();
                            });
                    },
                });

                // fetch the instance
                selectizeInstance = $select[0].selectize;
            });
            
            const calcItemTotal = (qty = 0) => {
                const itemPrice = "{{ $activeItem['price'] }}";

                if (qty == 0 || !qty) {
                    $('#item-qty').val(0);

                    $('#qty-sum').html('Free');
                } else {
                    let total = qty * itemPrice;

                    $('#item-qty').val(qty);
                    $('#qty-sum').html(`${toIDRFormat(total)}`);
                }
            } 

            const submitContent = () => {
                let isValid = document.querySelector('#form-content').reportValidity();
                if (isValid) {
                    editor.save().then((blocks) => {
                        if (!blocks.blocks.length) {
                            Toast2.fire({ 
                                icon: 'info', 
                                title: 'Body konten masih kosong.' 
                            });

                            return;
                        };

                        $('#body').val(JSON.stringify(blocks));
                        $('#tempUploadedImage').val(JSON.stringify(tempUploadedImage));
                        $('#form-content').submit();
                    }).catch((error) => {
                        console.log('Saving failed: ', error);
                        Toast2.fire({ 
                            icon: 'error', 
                            title: `Saving failed: ${error}` 
                        });
                    });
                }
            }

            const populateCategory = (selected = null) => {
                let categorySelect = $('#category_id');
                categorySelect.empty();

                if (!defaultCategory.length) {
                    categorySelect.append($('<option>').val('').html('Buat Kategori'));
                }

                for (const category in defaultCategory) {
                    let { id, title } = defaultCategory[category];
                    categorySelect.append($('<option>').val(id).html(title));
                }

                if (selected) { categorySelect.val(selected.id); }
                
                @if ($category_id = old('category_id', $content->category_id))
                    categorySelect.val('{{ $category_id }}'); 
                @endif
            }

            const addCategory = async () => {
                $('#btn-addCategory-submit').attr({"disabled": true}).html('Loading...');
                $('#btn-add-category').attr({"disabled": true});

                const formData = $('#form-addCategory').serializeJSON();

                await axios.post(`/api/contentcategory/create`, formData)
                    .then(({ data }) => {
                        const { message = 'Success' } = data;
                        const category = data.data;

                        defaultCategory.unshift(category);
                        
                        resetCategoryForm();
                        populateCategory(category);

                        Toast2.fire({ 
                            icon: 'info', 
                            title: message 
                        });
                    }).catch(({ response: { data } }) => {
                        const { message = 'Error!', errors = {} } = data;

                        handleAjaxError(errors);
                        Toast2.fire({ 
                            icon: 'error', 
                            title: message 
                        });
                    }).finally(() => {
                        $('#btn-addCategory-submit').attr({"disabled": false}).html('Submit');
                        $('#btn-add-category').attr({"disabled": false});
                    });
            }

            const removeCategory = async (id) => {
                $('#btn-remove-category').attr({"disabled": true});
                selectizeInstance.disable();

                await axios.delete(`/api/contentcategory/${id}/delete`)
                    .then(({ data }) => {
                        const { message = 'Success!' } = data;
                        
                        defaultCategory = defaultCategory.filter(category => category.id != id);
                        selectizeInstance.removeOption(id);
                        // populateCategory();

                        // Toast2.fire({ 
                        //     icon: 'info', 
                        //     title: message 
                        // });
                    }).catch(({ response: { data } }) => {
                        const { message = 'Error!', errors = {} } = data;
                        
                        Toast2.fire({ 
                            icon: 'error', 
                            title: message 
                        });
                    }).finally(() => {
                        $('#btn-remove-category').attr({"disabled": false});
                        selectizeInstance.enable();
                        selectizeInstance.refreshOptions();
                    });
            }

            const resetCategoryForm = () => {
                $('#form-addCategory')[0].reset();
                $('.error-title').html('');
                $('.input-title').removeClass('is-invalid')
            }

            const handleAjaxError = (errors) => {
                let html = [];
                for (const errorBag in errors) {
                    let errorMessages = errors[errorBag];
                    let message = populateError(errorMessages);

                    $(`.input-${errorBag}`).addClass('is-invalid');
                    $(`.error-${errorBag}`).html(message);

                    html.push(message);
                }

                return html;
            }

            const populateError = (errorMessages) => {
                if (!errorMessages.length) return;

                return `<ul class="mb-0 ps-3">
                            ${ errorMessages.map((item, index) => `<li class="text-danger">${item}</li>`).join('') }
                        </ul>`;
            }

            setTimeout(() => {
                $('#content-title').focus();
            }, 1 * 1000);

            // Editor JS
            editor = new EditorJS({
                holder: 'editorjs',
                autofocus: false,
                placeholder: 'Tulis kontenmu disini...',
                onReady: () => {
                    // console.log('Editor.js is ready to work!');
                },
                onChange: (args) => {
                    // console.log('Editor\'s content changed!' + JSON.stringify(args.blocks));
                },
                tools: {
                    header: {
                        class: Header,
                        inlineToolbar : true
                    },
                    delimiter: Delimiter,
                    paragraph: {
                        class: Paragraph,
                        inlineToolbar: true,
                    },
                    list: {
                        class: List,
                        inlineToolbar: true,
                        config: {
                            defaultStyle: 'unordered'
                        }
                    },
                    nestedlist: {
                        class: NestedList,
                        inlineToolbar: true,
                        toolbox: {
                            title: 'Nested List (Use Tab and Shift+Tab)',
                        }
                    },
                    checklist: {
                        class: Checklist,
                        inlineToolbar: true,
                    },
                    linkTool: {
                        class: LinkTool,
                        config: {
                            endpoint: metaUrl,
                            headers: {
                                'Accept': 'application/json'
                            }
                        }
                    },
                    Marker: {
                        class: Marker,
                    },
                    inlineCode: {
                        class: InlineCode,
                    },
                    alert: {
                        class: Alert,
                        inlineToolbar: true,
                        config: {
                            title: 'Judul',
                            desc: 'Deskripsi'
                        }
                    },
                    image: {
                        class: ImageTool,
                        config: {
                            /**
                             * Custom uploader
                             */
                            uploader: {
                                /**
                                 * Upload file to the server and return an uploaded image data
                                 * @param {File} file - file selected from the device or pasted by drag-n-drop
                                 * @return {Promise.<{success, file: {url}}>}
                                 */
                                async uploadByFile(file) {
                                    const options = { headers: {'Content-Type': 'multipart/form-data' }};
                                    const formData = new FormData();
                                    formData.append('image', file);
                                    formData.append('_token', '{{ csrf_token() }}');

                                    let result = await axios.post(`/client/content/manage/upload`, formData, options)
                                            .then(({ data }) => {
                                                const { message = 'Success' } = data;
                                                if (data.file.fileName) {
                                                    tempUploadedImage.push(data.file.fileName);
                                                }

                                                return data;
                                            }).catch(({ response: { data } }) => {
                                                const { message = 'Something went wrong!', errors = {} } = data;

                                                let html = handleAjaxError(errors).join('');
                                                showToast({ icon: 'danger', title: message, html });

                                                return data;
                                            }).finally(() => {

                                            });

                                    return result;
                                },
                                /**
                                 * Send URL-string to the server. Backend should load image by this URL and return an uploaded image data
                                 * @param {string} url - pasted image URL
                                 * @return {Promise.<{success, file: {url}}>}
                                 */
                                async uploadByUrl(url) {
                                    const options = { headers: {'Content-Type': 'multipart/form-data' }};
                                    const formData = new FormData();
                                    formData.append('url', url);
                                    formData.append('_token', '{{ csrf_token() }}');

                                    let result = await axios.post(`/client/content/manage/fetchImage`, formData, options)
                                            .then(({ data }) => {
                                                const { message = 'Success' } = data;
                                                if (data.file.fileName) {
                                                    tempUploadedImage.push(data.file.fileName);
                                                }

                                                return data;
                                            }).catch(({ response: { data } }) => {
                                                const { message = 'Something went wrong!', errors = {} } = data;

                                                let html = handleAjaxError(errors).join('');
                                                showToast({ icon: 'danger', title: message });

                                                return data;
                                            }).finally(() => {

                                            });

                                    return result;
                                },
                            }
                        },
                    },
                    code: CodeTool,
                    quote: {
                        class: Quote,
                        inlineToolbar: true,
                        config: {
                            quotePlaceholder: 'Masukan Quote',
                            captionPlaceholder: 'Penulis Quote',
                        },
                    },
                    // image: SimpleImage,
                    embed: Embed,
                }
            });

            // Populate default category list
            @foreach($categories as $category)
                defaultCategory.unshift(JSON.parse('{!! json_encode($category) !!}'));
            @endforeach

            // populateCategory();

            // Add category modal
            let addCategoryModalID = document.getElementById('addCategoryModal');
            let addCategoryModal = new bootstrap.Modal(addCategoryModalID, {
               keyboard: false,
               backdrop: 'static',
            });

            addCategoryModalID.addEventListener('show.bs.modal', function (event) {
                resetCategoryForm();
                setTimeout(() => {
                    $('#title').focus();
                }, 1000);
            });

            // Show bs modal category
            $(document).on('click', '#btn-add-category', () => {
                addCategoryModal.show();
            });
            
            // Add category
            $(document).on('submit', '#form-addCategory', () => {
                addCategory(); 
                return false;
            });

            // Handle attachment
            $(document).on('change', '#attachment', (e) => {
                let input = e.target;
                $('#attachment_info').html(input.files[0].name +` <i class="fas fa-times text-danger" id="attachment-clear"></i>`);
            });

            $(document).on('click', '#attachment-clear', () => {
                $('#attachment').val('');
                $('#attachment_info').html('');
            });

            // Handle thumbnail
            $(document).on('change', '#thumbnail', (e) => {
                let input = e.target;
                document.getElementById('thumbnail-preview').src = window.URL.createObjectURL(input.files[0]);
            });

            // Remove category
            $(document).on('click', '#btn-remove-category', () => {
                let categoryVal = $('#select-category').val();
                if(!categoryVal) {
                    Toast2.fire({ 
                        icon: 'info', 
                        title: 'Tidak ada kategori yang dipilih.' 
                    });

                    return;
                }

                ToastDelete.fire({
                    title: '@lang("page.sure")',
                    html: '@lang("page.sure_delete")',
                }).then(async (result) => {
                    if (result.isConfirmed) {
                        removeCategory(categoryVal);
                    }
                }).catch(swal.noop);
            });
            
            // Quantity item
            $(document).on('change input', '#item-qty', function() {
                let qty = parseInt($(this).val());
                calcItemTotal(qty);
            });

            // Submit and save as draft
            $(document).on('click', '#btn-save-draft', () => {
                $('#status').val(0);
                submitContent();
            });
            
            // Submit and save as publish
            $(document).on('click', '#btn-save-publish', () => {
                $('#status').val(1);
                submitContent();
            });
            
            // Delete actions
            $(document).on('click', '.btn-delete', function(e) {
                ToastDelete.fire({
                    title: '@lang("page.sure")',
                    html: '@lang("page.sure_delete")',
                }).then((result) => {
                    if (result.isConfirmed) {
                        $('#delete-form').submit();
                    }
                });
            });

            // Populate old value
            @if (($qty = old('qty', $content->qty)) && old('qty', $content->qty) != 0)
                let qty = parseInt("{{ $qty }}");
                calcItemTotal(qty);
            @endif
            
            @if ($tempUploadedImage = old('tempUploadedImage'))
                tempUploadedImage = JSON.parse('{!! $tempUploadedImage !!}');
            @endif

            @if ($body = old('body', json_encode($content->body)))
                let blocks = {!! $body !!};
                if (editor) {
                    editor.isReady.then(() => {
                        if (!blocks) {
                            console.log('Block body is empty!');
                            return;
                        }

                        editor.blocks.render(blocks); 
                        // console.log('Editor.js is ready to work!');
                    }).catch((reason) => {
                        console.log(`Editor.js initialization failed because of ${reason}`)
                    });
                } else {
                    console.log('Editor.js not initialization'); 
                }
            @endif
        })(jQuery);

    </script>
@endsection
