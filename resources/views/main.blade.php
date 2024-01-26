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

        .timeline-vertical .timeline-item:not(:last-child)::before{
            border-left: 2px solid #cc00cc!important;
        }
        .timeline-vertical .timeline-icon{
            border: 2px solid #cc00cc!important;
        }
        h5{
            font-size: 1.5rem!important;
        }
        @media (min-width: 992px){
            .timeline-vertical .timeline-item-content::before{
                 background: linear-gradient(89.7deg, rgb(0, 32, 95) 2.8%, rgb(132, 53, 142) 97.8%)
            }
           
        }
    </style>
</head>
<body>
<div class="container mt-5">
    <div class="row">
        <div class="col-lg-12">
            <div class="card mb-3">
                <div class="card-header bg-body-tertiary">
                    <div class="d-flex justify-content-between align-items-center ">
                        <h5 class="mb-0 d-inline">Timeline</h5>
                        <a data-bs-toggle="modal" data-bs-target="#add-modal" href="#" class="btn btn-success btn-sm"><i
                                class="fas fa-plus fa-fw"></i>Add New</a>
                    </div>
                </div>

                <div class="card-body px-sm-4 px-md-8 px-lg-6 px-xxl-8">
                    <div class="timeline-vertical">
                        @forelse($timelines as $key => $timeline)
                            @php
                                $dir = 'start';
                                if ($key % 2 != 0){
                                   $dir = 'end';
                                }
                            @endphp
                            <div class="timeline-item timeline-item-{{$dir}}">
                                <div class="timeline-icon icon-item icon-item-lg text-primary border-300"><span style="color:#800080"
                                        class="fs-8 fas fa-minus"></span></div>
                                <div class="row">
                                    <div class="col-lg-6 timeline-item-time">
                                        <div>
                                            <p class="fs-14 text-600 fw-semibold">{{\Carbon\Carbon::parse($timeline->date_time)->format('d-m-y h:i a')}}</p>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="timeline-item-content" >
                                            <div class="timeline-item-card" style="background: linear-gradient(89.7deg, rgb(0, 32, 95) 2.8%, rgb(132, 53, 142) 97.8%);color:#fff">
                                                <h5 class="mb-2" style="color:#fff">{{$timeline->title}}</h5>
                                                @if($timeline->comment)
                                                <div>
                                                    <p class="mb-0"><strong>Comment:</strong></p>
                                                    <p>{{$timeline->comment}}</p>
                                                </div>
                                                @endif
                                                @if($timeline->attachment)
                                                    <p class="m-0"><strong>Attachment</strong></p>
                                                    <div class="btn-group mt-1">
                                                        <a data-bs-toggle="tooltip" data-bs-placement="top"
                                                           data-bs-original-title="View" target="_blank"
                                                           class="btn btn-info btn-sm"
                                                           href="{{asset('storage/'.$timeline->attachment)}}"><i
                                                                class="fas fa-eye"></i></a>
                                                        <a data-bs-toggle="tooltip" data-bs-placement="top"
                                                           data-bs-original-title="Download" download
                                                           class="btn btn-primary btn-sm"
                                                           href="{{asset('storage/'.$timeline->attachment)}}"><i
                                                                class="fas fa-download"></i></a>
                                                        <a data-bs-toggle="tooltip" data-bs-placement="top"
                                                           data-bs-original-title="Attachment delete"
                                                           class="btn btn-danger btn-sm delete-attachment"
                                                           href="{{route('delete-attachment-data',['id'=>$timeline->id])}}"><i
                                                                class="fas fa-trash"></i></a>
                                                    </div>
                                                @endif
                                                <div class="action_btn">
                                                    <div class="btn-group">
                                                        <a data-bs-toggle="tooltip" data-bs-placement="top"
                                                           data-bs-original-title="Edit" href="#"
                                                           data-id="{{$timeline->id}}"
                                                           class="btn btn-warning btn-sm edit"><i
                                                                class="fas fa-edit"></i></a>
                                                        <a data-bs-toggle="tooltip" data-bs-placement="top"
                                                           data-bs-original-title="Delete"
                                                           href="{{route('delete',['id'=>$timeline->id])}}"
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
    </div