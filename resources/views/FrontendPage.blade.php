@php

function format_variants(array $variants) {
    foreach($variants as $variant) {
        $prices = array_map(function($price) {
            return $price['amount'] . ' ' . $price['currency'] . ' | ' . $price['price'] . '€';
        }, $variant['prices']);
        $variantStrings[] = $variant['name'] . ' (' . $variant['quantity'] . ') - ' . implode(', ', $prices);
    }
    return implode(', ', $variantStrings);
}

@endphp
<!DOCTYPE html>
<html data-bs-theme="light" lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>FIM</title>
    <link rel="stylesheet" href="{{ asset('bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/bss-overrides.css') }}">
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
</head>

<body>
    <!-- #region header -->
    <div class="container" id="body-cont">
        <div class="row rounded justify-content-center" id="title">
            <div class="col-4 header-container">
                <div>
                    <h1>{{ strtoupper($team->name) }}</h1>
                    <h6>powered by FIM.to</h6>
                </div>
            </div>
        </div>
    </div>
    <!-- #endregion -->
    <!-- #region filters -->
    <div class="container mt-4 mb-4">
        <div class="d-flex justify-content-center flex-wrap gap-2" id="cat-filters">
            <button class="btn btn-outline-primary rounded-pill filter-pill" type="button" data-category="flowers">Flowers</button>
            <button class="btn btn-outline-primary rounded-pill filter-pill" type="button" data-category="rosin">Rosin</button>
            <button class="btn btn-outline-primary rounded-pill filter-pill" type="button" data-category="vapes">Vapes</button>
            <button class="btn btn-outline-primary rounded-pill filter-pill" type="button" data-category="edibles">Edibles</button>
        </div>
    </div>
    <!-- #endregion -->
    <div class="container">
        <div class="row pt-3" id="menu">
            @foreach($flCats as $flCat)
                <div class="col-12">
                    <div class="products-layer-1">
                        <h1>{{ $flCat->prefix }} {{ $flCat->title }}</h1>
                        @foreach($team->assets()->where('category_id', $flCat->id)->get() as $asset)
                            <div class="col-12">
                                <div class="rounded d-flex overflow-hidden item-cont"><img class="flex-shrink-0 item-image" alt="bee, flower background, flower, pink, pollen, nectar, spring, macro, nature, environment, botany, pollination, insect, wildflower, beautiful flowers, green, detail, animal, closeup, flower wallpaper, beauty, contrast, insect on flower" src="{{ asset('img/g268ea1febf494e92f3f647bae75109ef6aaf0375e668ace47be9b1032e1ed702eaabf7b3233b38cca91cde8e2887e3d7130afc0789e23b3131ebf81847c187c1_640.jpg') }}" width="75" height="75">
                                    <div class="d-flex flex-column flex-grow-1 justify-content-between p-2">
                                        <div>
                                            <h5 class="mb-0 item-title">{{ $asset->title }}</h5><small class="item-desc">{{  \Illuminate\Support\Str::limit(strip_tags($asset->description), 100)  }}</small>
                                            <div class="fw-bold text-end"><em>{{ format_variants($asset->variants) }}</em></div>
                                        </div>
                                    </div>
                                </div>
                                <hr>
                            </div>
                        @endforeach
                        @foreach($slCats->where('parent_id', $flCat->id) as $slCat)
                            <div class="col-12">
                                <div class="products-layer-2">
                                    <h2>{{ $slCat->prefix }} {{ $slCat->title }}</h2>
                                    @foreach($team->assets()->where('category_id', $slCat->id)->get() as $asset)
                                        <div class="col-12 layer-2">
                                            <div class="rounded d-flex overflow-hidden item-cont"><img class="flex-shrink-0 item-image" alt="bee, flower background, flower, pink, pollen, nectar, spring, macro, nature, environment, botany, pollination, insect, wildflower, beautiful flowers, green, detail, animal, closeup, flower wallpaper, beauty, contrast, insect on flower" src="{{ asset('img/g268ea1febf494e92f3f647bae75109ef6aaf0375e668ace47be9b1032e1ed702eaabf7b3233b38cca91cde8e2887e3d7130afc0789e23b3131ebf81847c187c1_640.jpg') }}" width="75" height="75">
                                                <div class="d-flex flex-column flex-grow-1 justify-content-between p-2">
                                                    <div>
                                                        <h5 class="mb-0 item-title">{{ $asset->title }}</h5><small class="item-desc">{{  \Illuminate\Support\Str::limit(strip_tags($asset->description), 100)  }}</small>
                                                        <div class="fw-bold text-end"><em>Italic</em></div>
                                                    </div>
                                                </div>
                                            </div>
                                            <hr>
                                        </div>
                                    @endforeach
                                    @foreach($tlCats->where('parent_id', $slCat->id) as $tlCat)
                                        <div class="col-12">
                                            <div class="products-layer-3">
                                                <h3>{{ $tlCat->prefix }} {{ $tlCat->title }}</h3>
                                                @foreach($team->assets()->where('category_id', $tlCat->id)->get() as $asset)
                                                    <div class="col-12 layer-3">
                                                        <div class="rounded d-flex overflow-hidden item-cont"><img class="flex-shrink-0 item-image" alt="bee, flower background, flower, pink, pollen, nectar, spring, macro, nature, environment, botany, pollination, insect, wildflower, beautiful flowers, green, detail, animal, closeup, flower wallpaper, beauty, contrast, insect on flower" src="{{ asset('img/g268ea1febf494e92f3f647bae75109ef6aaf0375e668ace47be9b1032e1ed702eaabf7b3233b38cca91cde8e2887e3d7130afc0789e23b3131ebf81847c187c1_640.jpg') }}" width="75" height="75">
                                                            <div class="d-flex flex-column flex-grow-1 justify-content-between p-2">
                                                                <div>
                                                                    <h5 class="mb-0 item-title">{{ $asset->title }}</h5><small class="item-desc">{{  \Illuminate\Support\Str::limit(strip_tags($asset->description), 100)  }}</small>
                                                                    <div class="fw-bold text-end"><em>Italic</em></div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <hr>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endforeach
            <!-- #region heading 1
            <div class="col-12">
                <div class="products-layer-1">
                    <h1>Heading</h1>
                    <div class="col-12">
                        <div class="rounded d-flex overflow-hidden item-cont"><img class="flex-shrink-0 item-image" alt="bee, flower background, flower, pink, pollen, nectar, spring, macro, nature, environment, botany, pollination, insect, wildflower, beautiful flowers, green, detail, animal, closeup, flower wallpaper, beauty, contrast, insect on flower" src="{{ asset('img/g268ea1febf494e92f3f647bae75109ef6aaf0375e668ace47be9b1032e1ed702eaabf7b3233b38cca91cde8e2887e3d7130afc0789e23b3131ebf81847c187c1_640.jpg') }}" width="75" height="75">
                            <div class="d-flex flex-column flex-grow-1 justify-content-between p-2">
                                <div>
                                    <h5 class="mb-0 item-title">Trainwreck</h5><small class="item-desc">Mexican Sativa x Thai Sativa x Afghani Indica - Living Soil</small>
                                    <div class="fw-bold text-end"><em>Italic</em></div>
                                </div>
                            </div>
                        </div>
                        <hr>
                    </div>
                    <div class="col-12">
                        <div class="rounded d-flex overflow-hidden item-cont"><img class="flex-shrink-0 item-image" alt="bee, flower background, flower, pink, pollen, nectar, spring, macro, nature, environment, botany, pollination, insect, wildflower, beautiful flowers, green, detail, animal, closeup, flower wallpaper, beauty, contrast, insect on flower" src="{{ asset('img/g268ea1febf494e92f3f647bae75109ef6aaf0375e668ace47be9b1032e1ed702eaabf7b3233b38cca91cde8e2887e3d7130afc0789e23b3131ebf81847c187c1_640.jpg') }}" width="75" height="75">
                            <div class="d-flex flex-column flex-grow-1 justify-content-between p-2">
                                <div>
                                    <h5 class="mb-0 item-title">Runtz x Layer Cake</h5><small class="item-desc">Runtz x Layer Cake - Living Soil</small>
                                </div>
                            </div>
                            <div class="fw-bold text-end item-price"><em>30€/g | 280€/10g | 2500€/100g<br>200€/jar | 950€/5jars | 1850€/10jars</em></div>
                        </div>
                        <hr>
                    </div>
                    <!-- #region heading 2
                    <div class="col">
                        <div class="products-layer-2">
                            <h2>Heading</h2>
                            <div class="col-12 layer-2">
                                <div class="rounded d-flex overflow-hidden item-cont"><img class="flex-shrink-0 item-image" alt="bee, flower background, flower, pink, pollen, nectar, spring, macro, nature, environment, botany, pollination, insect, wildflower, beautiful flowers, green, detail, animal, closeup, flower wallpaper, beauty, contrast, insect on flower" src="{{ asset('img/g268ea1febf494e92f3f647bae75109ef6aaf0375e668ace47be9b1032e1ed702eaabf7b3233b38cca91cde8e2887e3d7130afc0789e23b3131ebf81847c187c1_640.jpg') }}" width="75" height="75">
                                    <div class="d-flex flex-column flex-grow-1 justify-content-between p-2">
                                        <div>
                                            <h5 class="mb-0 item-title">Trainwreck</h5><small class="item-desc">Mexican Sativa x Thai Sativa x Afghani Indica - Living Soil</small>
                                            <div class="fw-bold text-end"><em>Italic</em></div>
                                        </div>
                                    </div>
                                </div>
                                <hr>
                            </div>
                            <div class="col-12 layer-2">
                                <div class="rounded d-flex overflow-hidden item-cont"><img class="flex-shrink-0 item-image" alt="bee, flower background, flower, pink, pollen, nectar, spring, macro, nature, environment, botany, pollination, insect, wildflower, beautiful flowers, green, detail, animal, closeup, flower wallpaper, beauty, contrast, insect on flower" src="{{ asset('img/g268ea1febf494e92f3f647bae75109ef6aaf0375e668ace47be9b1032e1ed702eaabf7b3233b38cca91cde8e2887e3d7130afc0789e23b3131ebf81847c187c1_640.jpg') }}" width="75" height="75">
                                    <div class="d-flex flex-column flex-grow-1 justify-content-between p-2">
                                        <div>
                                            <h5 class="mb-0 item-title">Runtz x Layer Cake</h5><small class="item-desc">Runtz x Layer Cake - Living Soil</small>
                                        </div>
                                    </div>
                                    <div class="fw-bold text-end item-price"><em>30€/g | 280€/10g | 2500€/100g<br>200€/jar | 950€/5jars | 1850€/10jars</em></div>
                                </div>
                                <hr>
                            </div>
                            <!-- #region heading 3
                            <div class="col">
                                <div class="products-layer-3">
                                    <h3>Heading</h3>
                                    <div class="col-12 layer-3">
                                        <div class="rounded d-flex overflow-hidden item-cont"><img class="flex-shrink-0 item-image" alt="bee, flower background, flower, pink, pollen, nectar, spring, macro, nature, environment, botany, pollination, insect, wildflower, beautiful flowers, green, detail, animal, closeup, flower wallpaper, beauty, contrast, insect on flower" src="{{ asset('img/g268ea1febf494e92f3f647bae75109ef6aaf0375e668ace47be9b1032e1ed702eaabf7b3233b38cca91cde8e2887e3d7130afc0789e23b3131ebf81847c187c1_640.jpg') }}" width="75" height="75">
                                            <div class="d-flex flex-column flex-grow-1 justify-content-between p-2">
                                                <div>
                                                    <h5 class="mb-0 item-title">Trainwreck</h5><small class="item-desc">Mexican Sativa x Thai Sativa x Afghani Indica - Living Soil</small>
                                                    <div class="fw-bold text-end"><em>Italic</em></div>
                                                </div>
                                            </div>
                                        </div>
                                        <hr>
                                    </div>
                                    <div class="col-12 layer-3">
                                        <div class="rounded d-flex overflow-hidden item-cont"><img class="flex-shrink-0 item-image" alt="bee, flower background, flower, pink, pollen, nectar, spring, macro, nature, environment, botany, pollination, insect, wildflower, beautiful flowers, green, detail, animal, closeup, flower wallpaper, beauty, contrast, insect on flower" src="{{ asset('img/g268ea1febf494e92f3f647bae75109ef6aaf0375e668ace47be9b1032e1ed702eaabf7b3233b38cca91cde8e2887e3d7130afc0789e23b3131ebf81847c187c1_640.jpg') }}" width="75" height="75">
                                            <div class="d-flex flex-column flex-grow-1 justify-content-between p-2">
                                                <div>
                                                    <h5 class="mb-0 item-title">Runtz x Layer Cake</h5><small class="item-desc">Runtz x Layer Cake - Living Soil</small>
                                                </div>
                                            </div>
                                            <div class="fw-bold text-end item-price"><em>30€/g | 280€/10g | 2500€/100g<br>200€/jar | 950€/5jars | 1850€/10jars</em></div>
                                        </div>
                                        <hr>
                                    </div>
                                </div>
                            </div>
                            <!-- #endregion -->
                        </div>
                    </div>
                    <!-- #endregion -->
                </div>
            </div>
            <!-- #endregion -->
        </div>
    </div>
    <!-- #region footer -->
    <div class="container fw-bold text-center mt-3">
        <p>You want to create your own inventory page?<br><small id="footer-link"><strong>Join fim.to now!</strong></small></p>
    </div>
    <!-- #endregion -->
    <script src="{{ asset('bootstrap/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('js/main.js') }}"></script>
</body>

</html>