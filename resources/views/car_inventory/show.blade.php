@extends('layouts.theme')

@section('content')

 <h3 class="page-title">Car Inventory | <small style="color: green">{{ $car->year }} {{ $car->make }} {{ $car->model }}</small></h3>
<!-- <div class="panel panel-default" style="padding-top: 30px;"> -->
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">{{ $car->year }} {{ $car->make }} {{ $car->model }} <span class="label label-info" style="font-size:14px; margin-left:10px;">Price: ₦{{ number_format($car->price, 0, '.', ',') }}</span></h3>
                    </div>
                    <div class="panel-body">
                        @php
                            $thumbnailImage = $car->images->firstWhere('is_thumbnail', 1);
                            $displayImage = $thumbnailImage ? $thumbnailImage->image : ($car->images->count() > 0 ? $car->images->first()->image : null);
                        @endphp

                        @if($displayImage)
                            <img src="{{ asset('/vehicle_images/'.$displayImage) }}" alt="{{ $car->make }} {{ $car->model }}" class="img-responsive img-thumbnail center-block" id="mainCarImage" style="max-width: 100%; height: auto; margin-bottom: 15px; box-shadow: 0 4px 16px rgba(0,0,0,0.12); transition: box-shadow 0.3s;">
                            <div id="thumbnailGallery" style="margin-bottom: 10px; background: #f8f9fa; border-radius: 8px; padding: 10px 8px 6px 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.04);">
                                @php $maxVisible = 6; @endphp
                                <div id="thumbnailRow" style="display: inline-block;">
                                    @foreach($car->images->take($maxVisible) as $img)
                                        @php $borderColor = $img->is_thumbnail ? (Auth::user()->settings->secondary_color ?? '#337ab7') : 'transparent'; @endphp
                                        <img src="{{ asset('/vehicle_images/'.$img->image) }}"
                                            alt="Thumbnail"
                                            class="img-thumbnail thumbnail-item {{ $img->is_thumbnail ? 'active' : '' }} thumb-anim"
                                            data-main-image="{{ asset('/vehicle_images/'.$img->image) }}"
                                            style="width: 80px; height: 60px; object-fit: cover; cursor: pointer; border: 2px solid {{ $borderColor }}; display: inline-block; margin-right: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.08); transition: border-color 0.3s, transform 0.2s;{{ $img->is_thumbnail ? 'transform: scale(1.08); z-index:2;' : '' }}">
                                    @endforeach
                                    @if($car->images->count() > $maxVisible)
                                        <button id="expandGalleryBtn" class="btn btn-info btn-xs" style="vertical-align: top; margin: 15px 0 0 2px; font-weight: bold; letter-spacing: 0.5px; transition: background 0.2s;">+{{ $car->images->count() - $maxVisible }} more</button>
                                    @endif
                                </div>
                                <div id="allThumbnailsRow" style="display: none; margin-top: 10px;">
                                    @foreach($car->images as $img)
                                        @php $borderColor = $img->is_thumbnail ? (Auth::user()->settings->secondary_color ?? '#337ab7') : 'transparent'; @endphp
                                        <img src="{{ asset('/vehicle_images/'.$img->image) }}"
                                            alt="Thumbnail"
                                            class="img-thumbnail thumbnail-item {{ $img->is_thumbnail ? 'active' : '' }} thumb-anim"
                                            data-main-image="{{ asset('/vehicle_images/'.$img->image) }}"
                                            style="width: 80px; height: 60px; object-fit: cover; cursor: pointer; border: 2px solid {{ $borderColor }}; display: inline-block; margin: 0 8px 8px 0; box-shadow: 0 2px 8px rgba(0,0,0,0.08); transition: border-color 0.3s, transform 0.2s;{{ $img->is_thumbnail ? 'transform: scale(1.08); z-index:2;' : '' }}">
                                    @endforeach
                                    <button id="collapseGalleryBtn" class="btn btn-default btn-xs" style="vertical-align: top; margin: 15px 0 0 2px; font-weight: bold; letter-spacing: 0.5px; transition: background 0.2s;">Show less</button>
                                </div>
                            </div>
                            
                        @else
                            <div style="height: 220px; display: flex; align-items: center; justify-content: center; background: #f8f9fa; border-radius: 8px; margin-bottom: 24px; box-shadow: 0 2px 8px rgba(0,0,0,0.04);">
                                <p class="text-danger" style="margin:0; font-size: 18px;">No image uploaded for this car.</p>
                            </div>
                        @endif

                        <form action="{{ route('car-inventory.upload-image', $car->id) }}" method="POST" enctype="multipart/form-data" class="form-inline" style="margin-top:10px;">
                            @csrf
                            <div class="form-group">
                                <label for="imageUpload" class="sr-only">Upload Images</label>
                                <input type="file" name="image[]" id="imageUpload" class="form-control" multiple accept="image/*" required>
                            </div>
                            <button type="submit" class="btn btn-primary"><i class="fa fa-upload"></i> Upload Image(s)</button>
                            <p class="help-block">You can upload multiple images at once.</p>
                        </form>

                        @if($car->images->count())
                        <div class="text-center" style="margin-top: 15px;">
                            <p>Manage Thumbnails:</p>
                            @foreach($car->images as $img)
                                @if(!$img->is_thumbnail)
                                    <form action="{{ route('car-inventory.set-thumbnail', [$car->id, $img->id]) }}" method="POST" style="display:inline-block; margin-right: 5px; margin-bottom: 5px;">
                                        @csrf
                                        <button type="submit" class="btn btn-info btn-xs">Set Image {{ $loop->index + 1 }} as Thumbnail</button>
                                    </form>
                                @endif
                            @endforeach
                        </div>
                        @endif
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="panel panel-info">
                    <div class="panel-heading">
                        <h4 class="panel-title">Pricing</h4>
                    </div>
                    <div class="panel-body">
                        <div class="well text-center">
                            <div class="label" style="font-size: 14px; color: #666;">National Market Price</div>
                            <div class="price" style="font-size: 28px; font-weight: bold; color: #337ab7; margin-top: 5px;">₦{{ number_format($car->price, 0, '.', ',') }}</div>
                        </div>
                        @if($car->status == 'available')
                         <a href="{{ route('car-sales.order', $car->id) }}" class="btn btn-success btn-block">Sell</a>
                        @else
                        <button type="submit" class="btn btn-default btn-block"><i class="fa fa-check" disabled></i>Sold</button>
                        @endif
                        <div class="panel panel-default" style="margin-top: 20px;">
                            <div class="panel-heading">
                                <h4 class="panel-title">Car Details <small class="text-success">Inventory</small></h4>
                            </div>
                            <div class="panel-body">
                                <p><strong>Make:</strong> {{ $car->make }}</p>
                                <p><strong>Model:</strong> {{ $car->model }}</p>
                                <p><strong>Year:</strong> {{ $car->year }}</p>
                                <p><strong>VIN:</strong> {{ $car->vin }}</p>
                                <p><strong>Condition:</strong> {{ Str::headline($car->condition) }}</p>
                                <p><strong>Mileage:</strong> <i class="fa fa-tachometer"></i> {{ $car->mileage }}</p>
                                <p><strong>Fuel Type:</strong> <i class="fa fa-gas-pump"></i> {{ Str::headline($car->fuel_type) }}</p>
                                <p><strong>Drive Type:</strong> <i class="fa fa-road"></i> {{ Str::upper($car->drive_type) }}</p>
                                <p><strong>Transmission:</strong> <i class="fa fa-cogs"></i> {{ Str::headline($car->transmission) }}</p>
                                <p><strong>Color:</strong> {{ $car->color }}</p>
                                <p><strong>Price:</strong> ₦{{ number_format($car->price, 2, '.', ',') }}</p>
                                <p><strong>Status:</strong> <span class="label label-{{ $car->status == 'available' ? 'success' : 'default' }}">{{ ucfirst($car->status) }}</span></p>
                                <p><strong>Description:</strong> {{ $car->description }}</p>
                                <div class="btn-group" style="margin-top: 15px;">
                                    <a href="{{ route('car-inventory.edit', $car->id) }}" class="btn btn-warning"><i class="fa fa-edit"></i> Edit</a>
                                    <a href="{{ route('car-inventory.index') }}" class="btn btn-default">Back to List</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<!-- </div> -->
<style>
    .thumbnail-item:hover {
        border-color: {{ Auth::user()->settings->primary_color ?? '#5bc0de' }} !important;
        transform: scale(1.05);
        box-shadow: 0 4px 16px rgba(51,122,183,0.15);
    }
    #expandGalleryBtn, #collapseGalleryBtn {
        font-weight: bold;
        letter-spacing: 0.5px;
    }
    #expandGalleryBtn:hover, #collapseGalleryBtn:hover {
        background: #337ab7;
        color: #fff;
    }
    .thumb-anim {
        opacity: 0;
        animation: fadeInThumb 0.5s forwards;
    }
    @keyframes fadeInThumb {
        to { opacity: 1; }
    }
    #allThumbnailsRow {
        animation: fadeInRow 0.4s;
    }
    @keyframes fadeInRow {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: none; }
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        var mainCarImage = document.getElementById('mainCarImage');
        function updateThumbnailListeners() {
            var thumbnailItems = document.querySelectorAll('.thumbnail-item');
            thumbnailItems.forEach(function(thumbnail) {
                thumbnail.onclick = function() {
                    thumbnailItems.forEach(function(item) { item.classList.remove('active'); });
                    this.classList.add('active');
                    // Animate main image
                    mainCarImage.classList.add('main-img-anim');
                    mainCarImage.src = this.dataset.mainImage;
                    setTimeout(function(){
                        mainCarImage.classList.remove('main-img-anim');
                    }, 350);
                };
            });
        }
        updateThumbnailListeners();
        var activeThumbnail = document.querySelector('.thumbnail-item.active');
        if (activeThumbnail) {
            mainCarImage.src = activeThumbnail.dataset.mainImage;
        } else {
            var thumbnailItems = document.querySelectorAll('.thumbnail-item');
            if (thumbnailItems.length > 0) {
                thumbnailItems[0].classList.add('active');
                mainCarImage.src = thumbnailItems[0].dataset.mainImage;
            }
        }
        // Expand/collapse gallery logic
        var expandBtn = document.getElementById('expandGalleryBtn');
        var collapseBtn = document.getElementById('collapseGalleryBtn');
        var thumbnailRow = document.getElementById('thumbnailRow');
        var allThumbnailsRow = document.getElementById('allThumbnailsRow');
        if (expandBtn) {
            expandBtn.onclick = function() {
                thumbnailRow.style.display = 'none';
                allThumbnailsRow.style.display = 'inline-block';
                allThumbnailsRow.classList.add('fadeInRow');
                updateThumbnailListeners();
            };
        }
        if (collapseBtn) {
            collapseBtn.onclick = function() {
                allThumbnailsRow.style.display = 'none';
                thumbnailRow.style.display = 'inline-block';
                updateThumbnailListeners();
            };
        }
        // Main image animation
        var style = document.createElement('style');
        style.innerHTML = `.main-img-anim { animation: mainImgFade 0.35s; } @keyframes mainImgFade { from { opacity: 0.5; transform: scale(0.97); } to { opacity: 1; transform: scale(1); } }`;
        document.head.appendChild(style);
    });
</script>
@endsection