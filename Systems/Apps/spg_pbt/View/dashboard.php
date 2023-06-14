<main role="main" class="open">
    <?php

    ?>
    <div class="container pt-4 pl-4 pb-4">
        <div class="row">
            <div class="col-md-12 col-sm-12 col-12">
                <h1>Geo dashboard
                </h1>
                <p>Map-based GIS dashboard</p>
            </div>
        </div>
        <!-- Indicators -->
        <div class="row">
            <!-- Card -->
            <div class="col-md-4 col-sm-6 col-12 mb-2">
                <div class="card lena-card  no-border hover-shadow">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4 d-none d-md-block center-typcn">
                                <span class="typcn typcn-location-outline"></span>
                            </div>
                            <div class="col-md-8 col-12 col-sm-6">
                                <h4 class="font-weight-bold mt-1 mb-0">12 </h4>
                                <p class="mb-0">POIs</p>
                            </div>
                        </div>
                    </div>
                    <!-- Lena progress bar -->
                    <div class="lena-progress bg-lena-pastel-green" data-progress="50"></div>
                </div>
            </div>
            <!-- End of Card -->
            <!-- Card -->
            <div class="col-md-4 col-sm-6 col-12 mb-2">
                <div class="card lena-card  no-border hover-shadow">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4 d-none d-md-block center-typcn">
                                <span class="typcn typcn-wi-fi-outline"></span>
                            </div>
                            <div class="col-md-8 col-12 col-sm-6">
                                <h4 class="font-weight-bold mt-1 mb-0">9,7</h4>
                                <p class="mb-0">Signal strength</p>
                            </div>
                        </div>
                    </div>
                    <!-- Lena progress bar -->
                    <div class="lena-progress" data-progress="75"></div>
                </div>
            </div>
            <!-- End of Card -->
            <!-- Card -->
            <div class="col-md-4 col-sm-6 col-12 mb-2">
                <div class="card lena-card  no-border hover-shadow">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4 d-none d-md-block center-typcn">
                                <span class="typcn typcn-map"></span>
                            </div>
                            <div class="col-md-8 col-12 col-sm-6">
                                <h4 class="font-weight-bold mt-1 mb-0">5</h4>
                                <p class="mb-0">Map styles</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End of Card -->

        </div>
        <!-- End of indicators -->
        <div class="row mt-1">
            <div class="col-12">
                <div class="card lena-card no-border hover-shadow shadow d-block d-sm-none">
                    <div class="card-header">
                        Stocks by market
                    </div>
                    <div class="card-body">
                        <canvas class="mt-4" id="locationStocks1"></canvas>
                    </div>
                </div>
            </div>
        </div>


        <!-- Mapbox map -->
        <div class="row mt-3 mapBlock">
            <div class="col-md-12 col-sm-12 col-12">
                <!-- Map -->
                <div id="mapboxMap" class="map huge"></div>
                <!-- End Map -->
                <!-- Map card block -->
                <div class="card lena-card lena-main-card no-border hover-shadow shadow d-none d-md-block">
                    <div class="card-header">
                        Stocks by market
                    </div>
                    <div class="card-body">
                        <canvas class="mt-4" id="locationStocks"></canvas>
                    </div>
                </div>
                <!-- End Map card block -->
                <!-- Map card block -->
                <div class="card lena-card lena-secondary-card no-border hover-shadow shadow d-none d-md-block">
                    <div class="card-header">
                        Stocks by locations
                    </div>
                    <div class="card-body">
                        <ul class="lena-map-list">
                            <li>
                                <div class="row">
                                    <div class="col-6 lena-normal-text">
                                        Church St.
                                    </div>
                                    <div class="col-6 text-right">
                                        <div data-sparkline="line"></div>
                                    </div>
                                </div>
                            </li>
                            <li>
                                <div class="row">
                                    <div class="col-6 lena-normal-text">
                                        Murray St.
                                    </div>
                                    <div class="col-6 text-right">
                                        <div data-sparkline="line"></div>
                                    </div>
                                </div>
                            </li>
                            <li>
                                <div class="row">
                                    <div class="col-6 lena-normal-text">
                                        Broadway
                                    </div>
                                    <div class="col-6 text-right">
                                        <div data-sparkline="line"></div>
                                    </div>
                                </div>
                            </li>
                            <li>
                                <div class="row">
                                    <div class="col-6 lena-normal-text">
                                        Cortland St.
                                    </div>
                                    <div class="col-6 text-right">
                                        <div data-sparkline="line"></div>
                                    </div>
                                </div>
                            </li>
                            <li>
                                <div class="row">
                                    <div class="col-6 lena-normal-text">
                                        Fifth Ave.
                                    </div>
                                    <div class="col-6 text-right">
                                        <div data-sparkline="line"></div>
                                    </div>
                                </div>
                            </li>
                            <li>
                                <div class="row">
                                    <div class="col-6 lena-normal-text">
                                        Real-time datafeed
                                    </div>
                                    <div class="col-6 text-right">
                                        <label class="switch">
                                            <input type="checkbox">
                                            <span class="slider round"></span>
                                        </label>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
                <!-- End Map card block -->
            </div>
        </div>
        <!-- End of mapbox map -->



    </div>
</main>