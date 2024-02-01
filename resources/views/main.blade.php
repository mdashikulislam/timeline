<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="{{asset('theme.min.css')}}">
    <style>
        span.error-message {
            min-height: 28px;
            display: -webkit-box;
            display: -ms-flexbox;
            display: flex;
            -webkit-box-align: center;
            -ms-flex-align: center;
            align-items: center;
            padding: 5px 10px;
            width: 100%;
            color: #f44336;
            background: rgba(244, 67, 54, 0.1);
            font-size: 12px;
            line-height: 14px;
            border-radius: 4px;
            margin-top: 5px;
            font-family: 'Circular Std';
        }

        label.error {
            min-height: 28px;
            display: -webkit-box;
            display: -ms-flexbox;
            display: flex;
            -webkit-box-align: center;
            -ms-flex-align: center;
            align-items: center;
            padding: 5px 10px;
            width: 100%;
            color: #f44336;
            background: rgba(244, 67, 54, 0.1);
            font-size: 12px;
            line-height: 14px;
            border-radius: 4px;
            margin-top: 5px;
            font-family: 'Circular Std';
        }

        .timeline-item-card {
            position: relative;
        }

        .timeline-item-card .action_btn {
            position: absolute;
            top: 10px;
            right: 10px;
            visibility: hidden;
            transition: ease-in-out;
        }

        .timeline-item-card:hover .action_btn {
            visibility: visible;
        }

        .timeline-vertical .timeline-item:not(:last-child)::before {
            border-left: 2px solid #cc00cc !important;
        }

        .timeline-vertical .timeline-icon {
            border: 2px solid #cc00cc !important;
        }

        h5 {
            font-size: 1.5rem !important;
        }

        @media (min-width: 992px) {
            .timeline-vertical .timeline-item-content::before {
                background: linear-gradient(89.7deg, rgb(0, 32, 95) 2.8%, rgb(132, 53, 142) 97.8%)
            }

        }
    </style>
</head>
<body>
<div class="container mt-5">
    <div class="row mb-3">
        <div class="col-lg-12">
            <div class="d-flex justify-content-end">
                <a class="btn btn-falcon-danger" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();" href="#"><i
                        class="fa-solid fa-right-from-bracket fa-fw"></i>Logout</a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                </form>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12 col-12 mb-3">
            <div class="card h-lg-100 overflow-hidden">
                <div class="card-header bg-body-tertiary">
                    <div class="d-flex justify-content-between align-items-center ">
                        <h5 class="mb-0 d-inline">Timeline</h5>
                        <a data-bs-toggle="modal" data-bs-target="#add-timeline-modal" href="#"
                           class="btn btn-success btn-sm"><i class="fas fa-plus fa-fw"></i>Add New</a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive scrollbar">
                        <table class="table" id="timeline-table">
                            <thead>
                            <tr>
                                <th scope="col">Timeline Name</th>
                                <th scope="col">First Name</th>
                                <th scope="col">Last Name</th>
                                <th scope="col">Email</th>
                                <th scope="col">Editable Status</th>
                                <th scope="col">Created</th>
                                <th class="text-end" scope="col">Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($timelines as $timeline)
                                <tr>
                                    <td>{{$timeline->name}}</td>
                                    <td>{{$timeline->first_name}}</td>
                                    <td>{{$timeline->last_name}}</td>
                                    <td>{{$timeline->email}}</td>
                                    <td><span
                                            class="badge {{$timeline->is_edit == 'Active' ? 'bg-success':'bg-danger' }}">{{$timeline->is_edit}}</span>
                                    </td>
                                    <td>{{$timeline->created_at->format('m/d/Y H:i:s')}}</td>
                                    <td class="text-end">
                                        <div>
                                            <a  data-id="{{$timeline->id}}"
                                               class="btn btn-link timeline-view p-0" type="button"><span
                                                    class="text-500 fas fa-eye"></span></a>
                                            <a data-title="{{$timeline->name}}" data-id="{{$timeline->id}}"
                                               class="btn btn-link p-0 ms-2" type="button"
                                               data-bs-toggle="modal"
                                               data-bs-target="#edit-timeline-modal-{{$timeline->id}}"><span
                                                    class="text-500 fas fa-edit"></span></a>
                                            <a href="{{route('timeline.delete',['id'=>$timeline->id])}}"
                                               class="btn btn-link p-0 ms-2 delete-timeline" type="button"
                                               data-bs-toggle="tooltip"
                                               data-bs-placement="top" title="Delete"><span
                                                    class="text-500 fas fa-trash-alt"></span></a>
                                        </div>
                                    </td>
                                    <div class="modal fade" id="edit-timeline-modal-{{$timeline->id}}" tabindex="-1"
                                         role="dialog" aria-hidden="true">
                                        <div class="modal-dialog " role="document" style="max-width: 500px">
                                            <div class="modal-content position-relative">
                                                <div class="position-absolute top-0 end-0 mt-2 me-2 z-1">
                                                    <button
                                                        class="btn-close btn btn-sm btn-circle d-flex flex-center transition-base"
                                                        data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <form action="{{route('timeline.update')}}" method="POST"
                                                      id="edit-timeline-body">
                                                    @csrf
                                                    <input type="hidden" name="id" value="{{$timeline->id}}">
                                                    <div class="modal-body p-0">
                                                        <div class="rounded-top-3 py-3 ps-4 pe-6 bg-body-tertiary">
                                                            <h4 class="mb-1" id="modalExampleDemoLabel">Edit
                                                                timeline </h4>
                                                        </div>
                                                        <div class="p-4 pb-0">
                                                            <div class="mb-3">
                                                                <label class="col-form-label" for="recipient-name">Timeline
                                                                    Name:</label>
                                                                <input value="{{$timeline->name}}" class="form-control"
                                                                       name="title" type="text" required/>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label class="col-form-label" for="recipient-name">First
                                                                    Name:</label>
                                                                <input value="{{$timeline->first_name}}"
                                                                       class="form-control" name="first_name"
                                                                       type="text" required/>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label class="col-form-label" for="recipient-name">Last
                                                                    Name:</label>
                                                                <input value="{{$timeline->last_name}}"
                                                                       class="form-control" name="last_name" type="text"
                                                                       required/>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label class="col-form-label" for="recipient-name">Email:</label>
                                                                <input value="{{$timeline->email}}" class="form-control"
                                                                       name="email" type="text" required/>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label class="col-form-label" for="recipient-name">Editable
                                                                    Status:</label>
                                                                <select name="is_edit" class="form-control">
                                                                    {!! getStatusDropdown($timeline->is_edit) !!}
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button class="btn btn-secondary" type="button"
                                                                data-bs-dismiss="modal">Close
                                                        </button>
                                                        <button class="btn btn-primary" type="submit">Save</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </tr>
                            @empty
                            @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row mb-3">
        @forelse($timelines as $key => $timeline)
            <div class="col-lg-12 d-none nav-home-all" data-id="{{$timeline->id}}" id="nav-home-{{$timeline->id}}">
                <div class="card mb-3">
                    <div class="card-header bg-body-tertiary">
                        <div class="d-flex justify-content-between align-items-center ">
                            <h3>{{$timeline->name}}  @if($timeline->first_name) ({{$timeline->first_name}} {{$timeline->last_name}}) @endif</h3>
                            <a data-bs-toggle="modal" data-bs-target="#add-modal-{{$timeline->id}}" href="#"
                               class="btn btn-success btn-sm"><i
                                    class="fas fa-plus fa-fw"></i>Add New</a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div >
                            <div class="timeline-vertical">
                                <div class="d-flex justify-content-end">
                                    @php
                                        $copyLink = route('shared.timeline',['id'=>(base64_encode($timeline->id))]);
                                    @endphp
                                    <input type="hidden" id="copy-{{$timeline->id}}" value="{{$copyLink}}">
                                    <div class="btn-group">
                                        <a data-link="{{$copyLink}}" data-id="{{$timeline->id}}"
                                           data-email="{{$timeline->email}}" href="#"
                                           class="btn btn-info text-white send-mail"><i
                                                class="fa-solid fa-envelope fa-fw"></i>Share by email</a>
                                        <a data-toggle="popover" data-bs-container="body" data-bs-placement="top"
                                           data-trigger="manual" title="Copied" class="btn btn-dark copy-btn"
                                           data-id="{{$timeline->id}}" href="#"><i
                                                class="fa-solid fa-share-from-square fa-fw"></i>Share</a>
                                        <a target="_blank" href="{{$copyLink}}" class="btn btn-warning text-white "><i
                                                class="fa-solid fa-eye fa-fw"></i>View</a>
                                    </div>
                                </div>
                                @forelse($timeline->items as $key => $item)
                                    @php
                                        $dir = 'start';
                                        if ($key % 2 != 0){
                                           $dir = 'end';
                                        }
                                    @endphp
                                    <div class="timeline-item timeline-item-{{$dir}}">

                                        <div
                                            class="timeline-icon icon-item icon-item-lg text-primary border-300"><span
                                                style="color:#800080"
                                                class="fs-8 fas fa-minus"></span></div>
                                        <div class="row">
                                            <div class="col-lg-6 timeline-item-time">
                                                <div>
                                                    <p class="fs-14 text-600 fw-semibold">{{\Carbon\Carbon::parse($item->date_time)->format('d-m-y h:i a')}}</p>
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="timeline-item-content">
                                                    <div class="timeline-item-card"
                                                         style="background: linear-gradient(89.7deg, rgb(0, 32, 95) 2.8%, rgb(132, 53, 142) 97.8%);color:#fff">
                                                        @if(@$item->labels()->exists())
                                                            <h4 class="m-0"><span class="badge rounded-pill mb-2"
                                                                                  style="color:#fff;background: {{$item->labels->color}}">{{$item->labels->name}}</span>
                                                            </h4>
                                                        @endif
                                                        <h5 class="mb-2" style="color:#fff">{{$item->title}}</h5>
                                                        @if($item->comment)
                                                            <div>
                                                                <p class="mb-0"><strong>Comment:</strong></p>
                                                                <p>{{$item->comment}}</p>
                                                            </div>
                                                        @endif
                                                        @if($item->attachment)
                                                            <p class="m-0"><strong>Attachment</strong></p>
                                                            <div class="btn-group mt-1">
                                                                <a data-bs-toggle="tooltip" data-bs-placement="top"
                                                                   data-bs-original-title="View" target="_blank"
                                                                   class="btn btn-info btn-sm"
                                                                   href="{{asset('storage/'.$item->attachment)}}"><i
                                                                        class="fas fa-eye"></i></a>
                                                                <a data-bs-toggle="tooltip" data-bs-placement="top"
                                                                   data-bs-original-title="Download" download
                                                                   class="btn btn-primary btn-sm"
                                                                   href="{{asset('storage/'.$item->attachment)}}"><i
                                                                        class="fas fa-download"></i></a>
                                                                <a data-bs-toggle="tooltip" data-bs-placement="top"
                                                                   data-bs-original-title="Attachment delete"
                                                                   class="btn btn-danger btn-sm delete-attachment"
                                                                   href="{{route('delete-attachment-data',['id'=>$item->id])}}"><i
                                                                        class="fas fa-trash"></i></a>
                                                            </div>
                                                        @endif
                                                        <div class="action_btn">
                                                            <div class="btn-group">
                                                                <a data-bs-toggle="tooltip" data-bs-placement="top"
                                                                   data-bs-original-title="Edit" href="#"
                                                                   data-id="{{$item->id}}"
                                                                   class="btn btn-warning btn-sm edit"><i
                                                                        class="fas fa-edit"></i></a>
                                                                <a data-bs-toggle="tooltip" data-bs-placement="top"
                                                                   data-bs-original-title="Delete"
                                                                   href="{{route('delete',['id'=>$item->id])}}"
                                                                   class="btn btn-danger btn-sm delete"><i
                                                                        class="fas fa-trash"></i></a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal fade" id="add-modal-{{$timeline->id}}" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog " role="document" style="max-width: 500px">
                    <div class="modal-content position-relative">
                        <div class="position-absolute top-0 end-0 mt-2 me-2 z-1">
                            <button class="btn-close btn btn-sm btn-circle d-flex flex-center transition-base"
                                    data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form action="{{route('store')}}" method="POST" enctype="multipart/form-data" id="add-form">
                            @csrf
                            <div class="modal-body p-0">
                                <div class="rounded-top-3 py-3 ps-4 pe-6 bg-body-tertiary">
                                    <h4 class="mb-1" id="modalExampleDemoLabel">Add a new timeline item</h4>
                                </div>
                                <div class="p-4 pb-0">
                                    <input type="hidden" name="timeline" value="{{$timeline->id}}">
                                    <div class="mb-3">
                                        <label class="col-form-label" for="recipient-name">Title:</label>
                                        <input class="form-control" name="title" type="text" required/>
                                    </div>
                                    <div class="row">
                                        <div class="mb-3 col-lg-6">
                                            <label class="col-form-label" for="recipient-name">Date:</label>
                                            <input class="form-control" name="date" type="date" required/>
                                        </div>
                                        <div class="mb-3 col-lg-6">
                                            <label class="col-form-label" for="recipient-name">Time:</label>
                                            <input class="form-control" name="time" type="time" required/>
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label class="col-form-label" for="recipient-name">Attachment:</label>
                                        <input class="form-control" name="file" id="file1" type="file"/>
                                    </div>
                                    <div class="mb-3">
                                        <label class="col-form-label" for="recipient-name">Comment:</label>
                                        <textarea name="comment" class="form-control"></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Close</button>
                                <button class="btn btn-primary" type="submit">Save</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

        @empty
        @endforelse
    </div>

    <div class="modal fade" id="edit-label-modal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog " role="document" style="max-width: 500px">
            <div class="modal-content position-relative">
                <div class="position-absolute top-0 end-0 mt-2 me-2 z-1">
                    <button class="btn-close btn btn-sm btn-circle d-flex flex-center transition-base"
                            data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{route('label.update')}}" method="POST" id="edit-label-body">

                </form>
            </div>
        </div>
    </div>
    <div class="modal fade" id="add-timeline-modal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog " role="document" style="max-width: 500px">
            <div class="modal-content position-relative">
                <div class="position-absolute top-0 end-0 mt-2 me-2 z-1">
                    <button class="btn-close btn btn-sm btn-circle d-flex flex-center transition-base"
                            data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{route('timeline.store')}}" method="POST">
                    @csrf
                    <div class="modal-body p-0">
                        <div class="rounded-top-3 py-3 ps-4 pe-6 bg-body-tertiary">
                            <h4 class="mb-1" id="modalExampleDemoLabel">Add a new timeline </h4>
                        </div>
                        <div class="p-4 pb-0">
                            <div class="mb-3">
                                <label class="col-form-label" for="recipient-name">Timeline Name:</label>
                                <input class="form-control" name="title" type="text" required/>
                            </div>
                            <div class="mb-3">
                                <label class="col-form-label" for="recipient-name">First Name:</label>
                                <input class="form-control" name="first_name" type="text" required/>
                            </div>
                            <div class="mb-3">
                                <label class="col-form-label" for="recipient-name">Last Name:</label>
                                <input class="form-control" name="last_name" type="text" required/>
                            </div>
                            <div class="mb-3">
                                <label class="col-form-label" for="recipient-name">Email:</label>
                                <input class="form-control" name="email" type="text" required/>
                            </div>
                            <div class="mb-3">
                                <label class="col-form-label" for="recipient-name">Editable Status:</label>
                                <select name="is_edit" class="form-control">
                                    {!! getStatusDropdown() !!}
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Close</button>
                        <button class="btn btn-primary" type="submit">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal fade" id="add-label-modal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog " role="document" style="max-width: 500px">
            <div class="modal-content position-relative">
                <div class="position-absolute top-0 end-0 mt-2 me-2 z-1">
                    <button class="btn-close btn btn-sm btn-circle d-flex flex-center transition-base"
                            data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{route('label.store')}}" method="POST">
                    @csrf
                    <div class="modal-body p-0">
                        <div class="rounded-top-3 py-3 ps-4 pe-6 bg-body-tertiary">
                            <h4 class="mb-1" id="modalExampleDemoLabel">Add a new label </h4>
                        </div>
                        <div class="p-4 pb-0">
                            <div class="mb-3">
                                <label class="col-form-label" for="recipient-name">Label Name:</label>
                                <input class="form-control" name="name" type="text" required/>
                            </div>
                            <div class="mb-3">
                                <label class="col-form-label" for="recipient-name">label Color:</label>
                                <input class="form-control" name="color" type="color" required/>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Close</button>
                        <button class="btn btn-primary" type="submit">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="edit-modal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog " role="document" style="max-width: 500px">
            <div class="modal-content position-relative">

            </div>
        </div>
    </div>
    <div class="modal fade" id="send-mail-modal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog " role="document" style="max-width: 500px">
            <div class="modal-content position-relative">
                <div class="position-absolute top-0 end-0 mt-2 me-2 z-1">
                    <button class="btn-close btn btn-sm btn-circle d-flex flex-center transition-base"
                            data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{route('send-by-email')}}" method="POST" id="send-mail-body">

                </form>
            </div>
        </div>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.7.1.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.20.0/jquery.validate.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    $.validator.addMethod("accept", function (value, element, param) {

        // Split mime on commas in case we have multiple types we can accept
        var typeParam = typeof param === "string" ? param.replace(/\s/g, "") : "image/*",
            optionalValue = this.optional(element),
            i, file, regex;
        if (optionalValue) {
            return optionalValue;
        }
        if ($(element).attr("type") === "file") {
            typeParam = typeParam
                .replace(/[\-\[\]\/\{\}\(\)\+\?\.\\\^\$\|]/g, "\\$&")
                .replace(/,/g, "|")
                .replace(/\/\*/g, "/.*");

            // Check if the element has a FileList before checking each file
            if (element.files && element.files.length) {
                regex = new RegExp(".?(" + typeParam + ")$", "i");
                for (i = 0; i < element.files.length; i++) {
                    file = element.files[i];

                    // Grab the mimetype from the loaded file, verify it matches
                    if (!file.type.match(regex)) {
                        return false;
                    }
                }
            }
        }
        return true;
    }, $.validator.format("Please enter a value with a valid mimetype."));
</script>
<script>
    $(document).ready(function () {
        $(document).on('click','.timeline-view',function (e){
           e.preventDefault();
           var id = $(this).data('id')
            $('.nav-home-all').each(function (){
                if ($(this).data('id') != id){
                    if ($(this).hasClass('d-none') == false){
                        $(this).addClass('d-none');
                    }
                }
            });
           $('#nav-home-'+id).toggleClass('d-none');
        });

        $('[data-bs-toggle="tooltip"]').tooltip();
        $('#add-form').validate({
            errorElement: 'span',
            errorClass: 'error-message',
            rules: {
                title: 'required',
                date: 'required',
                time: 'required',
                file: {
                    required: false,
                    accept: "image/*,application/pdf,application/msword"
                }
            }
        });

        $(document).on('click', '.delete', function (e) {
            e.preventDefault();
            var link = $(this).attr('href');
            Swal.fire({
                title: "Are you sure?",
                text: "You won't be able to revert this!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, delete it!"
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = link;
                }
            });
        })
        $(document).on('click','.send-mail',function (e){
            e.preventDefault();
            var id = $(this).data('id');
            var link = $(this).data('link');
            var email = $(this).data('email') ? $(this).data('email') : '';
            var token = '{{csrf_token()}}';
            $('#send-mail-body').html(`<div class="modal-body p-0">
                            <div class="rounded-top-3 py-3 ps-4 pe-6 bg-body-tertiary">
                            <h4 class="mb-1" id="modalExampleDemoLabel">Share by email </h4>
                            </div>
                            <div class="p-4 pb-0">
                            <input type="hidden" name="id" value="${id}">
                            <input type="hidden" name="_token" value="${token}">
                            <input type="hidden" name="link" value="${link}">
                            <div class="mb-3">
                                <label class="form-label">Email Address</label>
                                <input required type="email" class="form-control" name="email" value="${email}">
                            </div></div></div>
                             <div class="modal-footer">
                                <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Close</button>
                                <button class="btn btn-primary" type="submit">Send</button>
                            </div>`);
            $('#send-mail-modal').modal('show');

        })
        $(document).on('click', '.delete-attachment', function (e) {
            e.preventDefault();
            var link = $(this).attr('href');
            Swal.fire({
                title: "Are you sure?",
                text: "You won't be able to revert this!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, delete it!"
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = link;
                }
            });
        })
        $(document).on('click', '.delete-label', function (e) {
            e.preventDefault();
            var link = $(this).attr('href');
            Swal.fire({
                title: "Are you sure?",
                text: "You won't be able to revert this!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, delete it!"
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = link;
                }
            });
        })
        $(document).on('click', '.delete-timeline', function (e) {
            e.preventDefault();
            var link = $(this).attr('href');
            Swal.fire({
                title: "Are you sure?",
                text: "You won't be able to revert this!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, delete it!"
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = link;
                }
            });
        })
        $(document).on('click', '.edit', function (e) {
            e.preventDefault();
            var id = $(this).data('id');
            $.ajax({
                url: '{{route('edit-data')}}',
                method: 'POST',
                data: {
                    '_token': '{{csrf_token()}}',
                    'id': id,
                },
                success: function (response) {
                    if (response.status) {
                        $('#edit-modal .modal-content').html(response.data);
                        $('#edit-modal').modal('show');
                        appendForm();
                    } else {
                        Swal.fire({
                            icon: "error",
                            title: "Oops...",
                            text: "Something went wrong!",
                        });
                    }
                }
            })
        })
        $(document).on('click', '.copy-btn', function (e) {
            e.preventDefault();
            var id = $(this).data('id');
            var hiddenInputValue = document.getElementById('copy-' + id).value;
            var tempInput = document.createElement('input');
            tempInput.style.position = 'absolute';
            tempInput.style.left = '-9999px';
            tempInput.value = hiddenInputValue;
            document.body.appendChild(tempInput);
            tempInput.select();
            document.execCommand('copy');
            document.body.removeChild(tempInput);
            $(this).popover('show');
            var copyBtn = $(this);
            setTimeout(function () {
                copyBtn.popover('hide');
            }, 2000);
        });

        function appendForm() {
            console.log('as')
            //$("#edit-form-app").validate().resetForm();
            $('#edit-form-app').validate({
                errorElement: 'span',
                errorClass: 'error-message',
                rules: {
                    title: 'required',
                    date: 'required',
                    time: 'required',
                    file: {
                        required: false,
                        accept: "image/*,application/pdf,application/msword"
                    }
                }
            });
        }

        $(document).on('click', '.edit-label', function (e) {
            e.preventDefault();
            var id = $(this).data('id');
            var title = $(this).data('name');
            var color = $(this).data('color');
            console.log(color)
            var token = '{{csrf_token()}}';
            $('#edit-label-body').html(`<div class="modal-body p-0">
                    <div class="rounded-top-3 py-3 ps-4 pe-6 bg-body-tertiary">
                        <h4 class="mb-1" id="modalExampleDemoLabel">Edit label </h4>
                    </div>
                    <div class="p-4 pb-0">
                        <input type="hidden" name="id" value="${id}">
                        <input type="hidden" name="_token" value="${token}">
                        <div class="mb-3">
                            <label class="col-form-label" for="recipient-name">Label Name:</label>
                            <input class="form-control" name="title" value="${title}" type="text" required/>
                        </div>
                        <div class="mb-3">
                            <label class="col-form-label" for="recipient-name">Label Color:</label>
                            <input class="form-control" name="color" value="${color}" type="color" required/>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Close</button>
                    <button class="btn btn-primary" type="submit">Updaate</button>
                </div>`);
            $('#edit-label-modal').modal('show');
        });
    });
</script>
</body>
</html>
@include('sweetalert::alert')
