@extends('layouts.autoserve')

@section('title', "Gallery for Job #$jobno")

@section('content')
   <div class="box">
    <div class="container">
        <h1 class="text-center mb-4">Image Gallery - Job #{{ $jobno }}</h1>
        <div class="row">
            @foreach($images as $image)
                <div class="col-sm-6 col-md-4 col-lg-3">
                    <div class="thumbnail">
                        <a href="{{ asset('job_images/' . $jobno . '/' . $image->getFilename()) }}" target="_blank">
                            <img src="{{ asset('job_images/' . $jobno . '/' . $image->getFilename()) }}" alt="Job Image" class="img-responsive">
                            <div class="caption text-center">
                                <p>Click to view</p>
                            </div>
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="text-center" style="margin-top: 20px;">
            <a href="https://api.whatsapp.com/send?text=Check%20out%20this%20gallery%20for%20Job%20%23{{ $jobno }}:%20{{ url()->current() }}" target="_blank" class="btn btn-success">
                <i class="fa fa-whatsapp"></i> Share on WhatsApp
            </a>
        </div>
    </div>
    </div>

    <style>
        .box .container {
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
        }

        .thumbnail {
            position: relative;
            overflow: hidden;
            transition: transform 0.3s ease;
        }

        .thumbnail:hover {
            transform: scale(1.05);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        .thumbnail img {
            transition: opacity 0.3s ease;
            object-fit: contain;
            width: 100%;
            height: auto;
        }

        .thumbnail:hover img {
            opacity: 0.9;
        }

        .caption {
            position: absolute;
            bottom: 0;
            background: rgba(0, 0, 0, 0.7);
            color: #fff;
            width: 100%;
            text-align: center;
            padding: 5px 0;
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .thumbnail:hover .caption {
            opacity: 1;
        }
    </style>
@endsection
