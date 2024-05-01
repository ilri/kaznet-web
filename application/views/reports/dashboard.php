<script src="https://code.highcharts.com/highcharts.js"></script>
    <script src="https://code.highcharts.com/modules/exporting.js"></script>
    <script src="https://code.highcharts.com/modules/heatmap.js"></script>
    <script src="https://code.highcharts.com/modules/export-data.js"></script>
    <script src="https://code.highcharts.com/modules/accessibility.js"></script>
    <script src="https://code.highcharts.com/modules/drilldown.js"></script>
    <!-- <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.3/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.3/dist/leaflet.js"></script> -->
    <link rel = "stylesheet" href = "http://cdn.leafletjs.com/leaflet-0.7.3/leaflet.css"/>
      <script src = "http://cdn.leafletjs.com/leaflet-0.7.3/leaflet.js"></script>
    <style>
        .nav-tabs.dashboard-nav .nav-item.show .nav-link,
        .nav-tabs.dashboard-nav .nav-link.active {
            color: #495057;
            background-color: transparent !important;
            border-color: #84837E #84837E #84837E !important;
            font-family: 'Open Sans';
            font-style: normal;
            font-weight: 500;
            font-size: 18px;
            line-height: 25px;
            padding: 10px 30px !important;
            color: #6d1024 !important;
        }

        .nav-tabs.dashboard-nav .nav-link {
            margin-bottom: -1px;
            background: transparent;
            font-family: 'Poppins';
            font-style: normal;
            padding: 10px 30px !important;
            font-weight: 400;
            font-size: 16px !important;
            line-height: 24px;
            color: #6d10248c !important;
            border: 1px solid transparent;
            border-top-left-radius: 5px !important;
            border-top-right-radius: 5px !important;
        }

        .chart-title {
            font-family: 'Open Sans';
            font-style: normal;
            font-weight: 600;
            font-size: 18px;
            line-height: 25px;
            color: #000000;
        }

        .card-shadow {
            background: #FFFFFF;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
            margin-bottom: 10px;
        }

        .h-386px {
            height: 386px;
            min-height: 386px;
        }

        .map_height {
            width: 100%;
            height: 300px;
        }

        .primary-vl {
            border-left: 4px solid #5877A3;
            height: 30px;
        }

        .primary-v2 {
            border-left: 4px solid #E49443;
            height: 30px;
        }

        .primary-v3 {
            border-left: 4px solid #6A9F58;
            height: 30px;
        }

        .primary-v4 {
            border-left: 4px solid #F1A2A7;
            height: 30px;
        }

        .primary-v5 {
            border-left: 4px solid #6FA1E7;
            height: 30px;
        }

        .primary-v6 {
            border-left: 4px solid #FFB6BA;
            height: 30px;
        }

        .primary-v7 {
            border-left: 4px solid #C8E76F;
            height: 30px;
        }

        .primary-v8 {
            border-left: 4px solid #CDCDCD;
            height: 30px;
        }

        .primary-v9 {
            border-left: 4px solid #F7BA1E;
            height: 30px;
        }

        .primary-v10 {
            border-left: 4px solid #14C9C9;
            height: 30px;
        }

        .primary-v11 {
            border-left: 4px solid #FFB6BA;
            height: 30px;
        }

        .w-100px {
            width: 100px;
        }

        .chart-legend-title {
            width: 100px !important;
            font-style: normal;
            font-weight: 400;
            font-size: 14px;
            line-height: 22px;
            align-items: center;
            color: #4E5969;
        }

        .large-bold {
            font-style: normal;
            font-weight: 500;
            font-size: 20px;
            line-height: 28px;
            color: #1D2129;
        }
        #new_map_kml {
            height: 540px;
            width: 100%;
        }
        .leaflet-popup-content {
            margin: 13px 19px;
            line-height: 1.4;
            width: auto !important;
            white-space: nowrap;
        }
    </style>
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12 col-md-12 col-lg-12 mt-3">
                <nav>
                    <ol class="breadcrumb mb-0 bg-transparent">
                        <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                    </ol>
                </nav>
            </div>
        </div>

        <div class="row mt-3">
            <div class="col-sm-12 col-md-12 col-lg-12">
                <div class="card border-0">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-12 col-md-12 col-lg-12">
                                <!-- Nav tabs -->
                                <ul class="nav nav-tabs dashboard-nav">
                                    <li class="nav-item">
                                        <a class="nav-link active" data-toggle="tab"
                                            href="#dashboardUsers">Users</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" data-toggle="tab" id="tab_2"
                                            href="#dashboardHousehold">Household</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" data-toggle="tab" id="tab_3"
                                            href="#dashboardMarket">Market</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" data-toggle="tab" id="tab_4" 
                                            href="#dashboardRangeland">Rangeland</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="tab_5" data-toggle="tab"
                                            href="#taskPayment">Task & Payment</a>
                                    </li>
                                </ul>
                                <!-- Tab panes -->
                            </div>
                            <div class="col-sm-12 col-md-12 col-lg-12">
                                <div class="tab-content mt-4">
                                    <div class="tab-pane active" id="dashboardUsers">
                                        <!-- Map start -->
                                        <div class="row">
                                            <div class="col-sm-12 col-md-10 col-lg-10">
                                                <div class="row">
                                                    <div class="col-sm-12 col-md-6 col-lg-4">
                                                        <div class="form-group my-3">
                                                            <label for="" class="label-text">Country<span class="text-danger"> *</span></label>
                                                            <select class="form-control" id="country_id" name="country_id">
                                                                <option value="">Select Country</option>
                                                                <?php 
                                                                foreach($lkp_country as $key => $cvalue){ ?>
                                                                    <option value="<?=$cvalue['country_id'];?>"><?=$cvalue['name'];?></option>
                                                                <?php  } ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-12 col-md-6 col-lg-4">
                                                        <div class="form-group my-3">
                                                            <label for="" class="label-text">UAI</label>
                                                            <select class="form-control" id="uai_id" name="uai_id">
                                                                <option value="">Select UAI</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-12 col-md-6 col-lg-4">
                                                        <div class="form-group my-3">
                                                            <label for="" class="label-text" >Sub Location</label>
                                                            <select class="form-control" id="sub_location_id" name="sub_location_id">
                                                                <option value="">Select Sub Location</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-12 col-md-6 col-lg-4">
                                                        <div class="form-group my-3">
                                                            <label for="" class="label-text">Cluster</label>
                                                            <select class="form-control" id="cluster_id" name="cluster_id">
                                                                <option value="">Select Cluster</option>
                                                                <!-- <?php 
                                                                foreach($lkp_cluster as $key => $clvalue){ ?>
                                                                    <option value="<?=$clvalue['cluster_id'];?>"><?=$clvalue['name'];?></option>
                                                                <?php  } ?> -->
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-12 col-md-6 col-lg-4">
                                                        <div class="form-group my-3">
                                                            <label for="" class="label-text">Survey Start Date</label>
                                                            <input type="date" name="start_date" class="form-control" placeholder="Date" />
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-12 col-md-6 col-lg-4">
                                                        <div class="form-group my-3">
                                                        <label for="" class="label-text">Survey End Date</label>
                                                        <input type="date" name="end_date" class="form-control" placeholder="Date" />
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-12 col-md-2 col-lg-2 text-center" style="display:grid;">
                                                <button type="reset" class="btn btn-reset-active text-white mt-46px reset">Reset</button>
                                                <button class="btn btn-submit-active text-white mt-55px get_data" id="get_data_t1" disabled style="background-color:gray">Submit</button>
                                            </div>
                                        </div>
                                        

                                        <!-- <div class="row mt-4">
                                            <div class="col-sm-12 col-md-8 col-lg-8">
                                                <img src="../assets/images/dashboardusers.png" alt=""
                                                    width="100%" height="386px">
                                            </div>
                                            <div class="col-sm-12 col-md-3 col-lg-3">
                                                <div class="card border-0 card-shadow h-386px">
                                                    <div class="card-body">
                                                        <ul class="list-group">
                                                            <li class="list-group-item border-0"><img
                                                                    src="../assets/images/location-pin.svg">
                                                                <span class="pl-2">Location 1</span>
                                                            </li>
                                                            <li class="list-group-item border-0"><img
                                                                    src="../assets/images/location-pin.svg">
                                                                <span class="pl-2">Location 2</span>
                                                            </li>
                                                            <li class="list-group-item border-0"><img
                                                                    src="../assets/images/location-pin.svg">
                                                                <span class="pl-2">Location 3</span>
                                                            </li>
                                                            <li class="list-group-item border-0"><img
                                                                    src="../assets/images/location-pin.svg">
                                                                <span class="pl-2">Location 4</span>
                                                            </li>
                                                            <li class="list-group-item border-0"><img
                                                                    src="../assets/images/location-pin.svg">
                                                                <span class="pl-2">Location 5</span>
                                                            </li>
                                                            <li class="list-group-item border-0"><img
                                                                    src="../assets/images/location-pin.svg">
                                                                <span class="pl-2">Location 6</span>
                                                            </li>
                                                            <li class="list-group-item border-0"><img
                                                                    src="../assets/images/location-pin.svg">
                                                                <span class="pl-2">Location 7</span>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div> -->
                                        <!-- Map End -->
                                        <div class="div_survey_deatils_view"></div>
                                        
                                    </div>
                                    <div class="tab-pane fade" id="dashboardHousehold">
                                        <div class="row">
                                            <div class="col-sm-12 col-md-10 col-lg-10">
                                                <div class="row">
                                                    <div class="col-sm-12 col-md-6 col-lg-4">
                                                        <div class="form-group my-3">
                                                            <label for="" class="label-text">Country<span class="text-danger"> *</span></label>
                                                            <select class="form-control" id="country_id_2" name="country_id_2">
                                                                <option value="">Select Country</option>
                                                                <?php 
                                                                foreach($lkp_country as $key => $cvalue){ ?>
                                                                    <option value="<?=$cvalue['country_id'];?>"><?=$cvalue['name'];?></option>
                                                                <?php  } ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-12 col-md-6 col-lg-4">
                                                        <div class="form-group my-3">
                                                            <label for="" class="label-text">UAI</label>
                                                            <select class="form-control" id="uai_id_2" name="uai_id_2">
                                                                <option value="">Select UAI</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-12 col-md-6 col-lg-4">
                                                        <div class="form-group my-3">
                                                            <label for="" class="label-text" >Sub Location</label>
                                                            <select class="form-control" id="sub_location_id_2" name="sub_location_id_2">
                                                                <option value="">Select Sub Location</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-12 col-md-6 col-lg-4">
                                                        <div class="form-group my-3">
                                                            <label for="" class="label-text">Cluster</label>
                                                            <select class="form-control" id="cluster_id_2" name="cluster_id_2">
                                                                <option value="">Select Cluster</option>
                                                                <!-- <?php 
                                                                foreach($lkp_cluster as $key => $clvalue){ ?>
                                                                    <option value="<?=$clvalue['cluster_id'];?>"><?=$clvalue['name'];?></option>
                                                                <?php  } ?> -->
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-12 col-md-6 col-lg-4">
                                                        <div class="form-group my-3">
                                                            <label for="" class="label-text">Survey Start Date</label>
                                                            <input type="date" name="start_date_2" class="form-control" placeholder="Date" />
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-12 col-md-6 col-lg-4">
                                                        <div class="form-group my-3">
                                                        <label for="" class="label-text">Survey End Date</label>
                                                        <input type="date" name="end_date_2" class="form-control" placeholder="Date" />
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-12 col-md-2 col-lg-2 text-center" style="display:grid;">
                                                <button type="reset" class="btn btn-reset-active text-white mt-46px reset">Reset</button>
                                                <button class="btn btn-submit-active text-white mt-55px get_data_2" id="get_data_t2" disabled style="background-color:gray">Submit</button>
                                            </div>
                                        </div>
                                        <div class="div_survey_deatils_t2_view"></div>
                                        
                                    </div>

                                    <div class="tab-pane fade" id="dashboardMarket">
                                        <div class="row">
                                            <div class="col-sm-12 col-md-10 col-lg-10">
                                            <div class="row">
                                                    <div class="col-sm-12 col-md-6 col-lg-4">
                                                        <div class="form-group my-3">
                                                            <label for="" class="label-text">Country<span class="text-danger"> *</span></label>
                                                            <select class="form-control" id="country_id_3" name="country_id_3">
                                                                <option value="">Select Country</option>
                                                                <?php 
                                                                foreach($lkp_country as $key => $cvalue){ ?>
                                                                    <option value="<?=$cvalue['country_id'];?>"><?=$cvalue['name'];?></option>
                                                                <?php  } ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-12 col-md-6 col-lg-4">
                                                        <div class="form-group my-3">
                                                            <label for="" class="label-text">UAI</label>
                                                            <select class="form-control" id="uai_id_3" name="uai_id_3">
                                                                <option value="">Select UAI</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-12 col-md-6 col-lg-4">
                                                        <div class="form-group my-3">
                                                            <label for="" class="label-text" >Sub Location</label>
                                                            <select class="form-control" id="sub_location_id_3" name="sub_location_id_3">
                                                                <option value="">Select Sub Location</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-12 col-md-6 col-lg-3">
                                                        <div class="form-group my-3">
                                                            <label for="" class="label-text">Cluster</label>
                                                            <select class="form-control" id="cluster_id_3" name="cluster_id_3">
                                                                <option value="">Select Cluster</option>
                                                                <!-- <?php 
                                                                foreach($lkp_cluster as $key => $clvalue){ ?>
                                                                    <option value="<?=$clvalue['cluster_id'];?>"><?=$clvalue['name'];?></option>
                                                                <?php  } ?> -->
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-12 col-md-6 col-lg-3">
                                                        <div class="form-group my-3">
                                                            <label for="" class="label-text">Survey Start Date</label>
                                                            <input type="date" name="start_date_3" class="form-control" placeholder="Date" />
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-12 col-md-6 col-lg-3">
                                                        <div class="form-group my-3">
                                                        <label for="" class="label-text">Survey End Date</label>
                                                        <input type="date" name="end_date_3" class="form-control" placeholder="Date" />
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-12 col-md-6 col-lg-3">
                                                        <div class="form-group my-3">
                                                            <label for="" class="label-text">Market</label>
                                                            <select class="form-control" id="market_id_3" name="market_id_3">
                                                                <option value="">Select Market</option>
                                                                <!-- <?php 
                                                                foreach($market_list as $key => $cvalue){ ?>
                                                                    <option value="<?=$cvalue['market_id'];?>"><?=$cvalue['name'];?></option>
                                                                <?php  } ?> -->
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-12 col-md-2 col-lg-2 text-center" style="display:grid;">
                                                <button type="reset" class="btn btn-reset-active text-white mt-46px reset">Reset</button>
                                                <button class="btn btn-submit-active text-white mt-55px get_data_3" id="get_data_t3" style="background-color:gray">Submit</button>
                                            </div>
                                        </div>
                                        <div class="market_tab_3_view_details" >
                                        </div>
                                        <!-- <div class="row mt-4">
                                            <div class="col-sm-12 col-md-6 col-lg-6">
                                                <div class="card border-0 card-shadow">
                                                    <div class="card-body">
                                                        <h4 class="chart-title">Index Commodities</h4>
                                                        <div class="map_height" id="Index_Commodities_Market_2"
                                                            style="width:100%;height: 260px;">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-12 col-md-6 col-lg-6">
                                                <div class="card border-0 card-shadow">
                                                    <div class="card-body">
                                                        <h4 class="chart-title">Dry Food</h4>
                                                        <div class="map_height" id="Dry_Food_Market"
                                                            style="width:100%;height: 260px;">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div> -->

                                        <!-- <div class="row mt-4">
                                            <div class="col-sm-12 col-md-6 col-lg-6">
                                                <div class="card border-0 card-shadow">
                                                    <div class="card-body">
                                                        <h4 class="chart-title">Livestock Volumes</h4>
                                                        <div class="map_height" id="Livestock_Volumes_Market"
                                                            style="width:100%;height: 260px;">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div> -->


                                    </div>
                                    <div class="tab-pane fade" id="dashboardRangeland">
                                    <div class="row">
                                            <div class="col-sm-12 col-md-10 col-lg-10">
                                                <div class="row">
                                                    <div class="col-sm-12 col-md-6 col-lg-4">
                                                        <div class="form-group my-3">
                                                            <label for="" class="label-text">Country<span class="text-danger"> *</span></label>
                                                            <select class="form-control" id="country_id_4" name="country_id_4">
                                                                <option value="">Select Country</option>
                                                                <?php 
                                                                foreach($lkp_country as $key => $cvalue){ ?>
                                                                    <option value="<?=$cvalue['country_id'];?>"><?=$cvalue['name'];?></option>
                                                                <?php  } ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-12 col-md-6 col-lg-4">
                                                        <div class="form-group my-3">
                                                            <label for="" class="label-text">UAI</label>
                                                            <select class="form-control" id="uai_id_4" name="uai_id_4">
                                                                <option value="">Select UAI</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-12 col-md-6 col-lg-4">
                                                        <div class="form-group my-3">
                                                            <label for="" class="label-text" >Sub Location</label>
                                                            <select class="form-control" id="sub_location_id_4" name="sub_location_id_4">
                                                                <option value="">Select Sub Location</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-12 col-md-6 col-lg-4">
                                                        <div class="form-group my-3">
                                                            <label for="" class="label-text">Cluster</label>
                                                            <select class="form-control" id="cluster_id_4" name="cluster_id_4">
                                                                <option value="">Select Cluster</option>
                                                                <!-- <?php 
                                                                foreach($lkp_cluster as $key => $clvalue){ ?>
                                                                    <option value="<?=$clvalue['cluster_id'];?>"><?=$clvalue['name'];?></option>
                                                                <?php  } ?> -->
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-12 col-md-6 col-lg-4">
                                                        <div class="form-group my-3">
                                                            <label for="" class="label-text">Survey Start Date</label>
                                                            <input type="date" name="start_date_4" class="form-control" placeholder="Date" />
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-12 col-md-6 col-lg-4">
                                                        <div class="form-group my-3">
                                                        <label for="" class="label-text">Survey End Date</label>
                                                        <input type="date" name="end_date_4" class="form-control" placeholder="Date" />
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-12 col-md-2 col-lg-2 text-center" style="display:grid;">
                                                <button type="reset" class="btn btn-reset-active text-white mt-46px reset">Reset</button>
                                                <button class="btn btn-submit-active text-white mt-55px get_data_4" id="get_data_t4" disabled style="background-color:gray">Submit</button>
                                            </div>
                                        </div>
                                        <div class="market_tab_4_view_details"></div>
                                    </div>
                                    <div class="tab-pane fade" id="taskPayment">                                               
                                        <div class="row">
                                            <div class="col-sm-12 col-md-10 col-lg-10">
                                                <div class="row">
                                                    <div class="col-sm-12 col-md-6 col-lg-4">
                                                        <div class="form-group my-3">
                                                            <label for="" class="label-text">Country<span class="text-danger"> *</span></label>
                                                            <select class="form-control" id="country_id_5" name="country_id_5">
                                                                <option value="">Select Country</option>
                                                                <?php 
                                                                foreach($lkp_country as $key => $cvalue){ ?>
                                                                    <option value="<?=$cvalue['country_id'];?>"><?=$cvalue['name'];?></option>
                                                                <?php  } ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-12 col-md-6 col-lg-4">
                                                        <div class="form-group my-3">
                                                            <label for="" class="label-text">UAI</label>
                                                            <select class="form-control" id="uai_id_5" name="uai_id_5">
                                                                <option value="">Select UAI</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-12 col-md-6 col-lg-4">
                                                        <div class="form-group my-3">
                                                            <label for="" class="label-text" >Sub Location</label>
                                                            <select class="form-control" id="sub_location_id_5" name="sub_location_id_5">
                                                                <option value="">Select Sub Location</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-12 col-md-6 col-lg-3">
                                                        <div class="form-group my-3">
                                                            <label for="" class="label-text">Cluster</label>
                                                            <select class="form-control" id="cluster_id_5" name="cluster_id_5">
                                                                <option value="">Select Cluster</option>
                                                                <!-- <?php 
                                                                foreach($lkp_cluster as $key => $clvalue){ ?>
                                                                    <option value="<?=$clvalue['cluster_id'];?>"><?=$clvalue['name'];?></option>
                                                                <?php  } ?> -->
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-12 col-md-6 col-lg-3">
                                                        <div class="form-group my-3">
                                                            <label for="" class="label-text">Survey Start Date</label>
                                                            <input type="date" name="start_date_5" class="form-control" placeholder="Date" />
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-12 col-md-6 col-lg-3">
                                                        <div class="form-group my-3">
                                                        <label for="" class="label-text">Survey End Date</label>
                                                        <input type="date" name="end_date_5" class="form-control" placeholder="Date" />
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-12 col-md-6 col-lg-3">
                                                        <div class="form-group my-3">
                                                        <label for="" class="label-text">Task Type</label>
                                                        <select  class="form-control" id="task_id" name="task_id">
                                                            <option value="">Select Task</option>
                                                            <?php 
                                                                foreach($task_list as $key => $form){ ?>
                                                                    <option value="<?=$form['id'];?>"><?=$form['title'];?></option>
                                                            <?php  } ?>
                                                            <!-- contributor profile added manually -->
                                                                <option value="99">Household profile</option>
                                                        </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-12 col-md-2 col-lg-2 text-center" style="display:grid;">
                                                <button type="reset" class="btn btn-reset-active text-white mt-46px reset">Reset</button>
                                                <button class="btn btn-submit-active text-white mt-55px get_data_5" id="get_data_t5" disabled style="background-color:gray">Submit</button>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-12 col-md-12 col-lg-12">
                                                <div class="div_task_view"></div>
                                            </div>
                                        </div>
                                        
                                    </div>
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.4.js"></script>
    <script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="https://code.highcharts.com/modules/export-data.js"></script>
<script>
    $(function(){
        getSurveyDeatilsViewT1();
        loginrole = <?php echo $this->session->userdata('role')?>;
	});
    // $( document ).ready(function() {
    //     $('.get_data').trigger('click');
    // });
    $('body').on('click', '#get_data_t1', function(){
        		getSurveyDeatilsViewT1();
	});
    
    $('body').on('click', '#tab_2', function(){
        		getSurveyDeatilsViewT2();
	});
    $('body').on('click', '#get_data_t2', function(){
        		getSurveyDeatilsViewT2();
	});
    $('body').on('click', '#tab_3', function(){
        		getSurveyDeatilsViewT3();
	});
    $('body').on('click', '#get_data_t3', function(){
        		getSurveyDeatilsViewT3();
	});
    $('body').on('click', '#tab_4', function(){
        		getSurveyDeatilsViewT4();
	});
    $('body').on('click', '#get_data_t4', function(){
        		getSurveyDeatilsViewT4();
	});
    $('.reset').on('click', function(){
		location.reload();
	});

	 $('#country_id').on('change', function(){
        var country_id=$(this).val();
        if(country_id != '')
        {
            $.ajax('<?=base_url()?>/reports/getClusterByCountry', {
                type: 'POST',  // http method
                data: { country_id: country_id },  // data to submit
                success: function (data) {
                    $('#cluster_id').html(data);
                }
            });

			$.ajax('<?=base_url()?>reports/getUaiByCountry', {
                type: 'POST',  // http method
                data: { country_id: country_id },  // data to submit
                success: function (data) {
                    $('#uai_id').html(data);
                }
            });
            if(loginrole==1){
                $('.get_data').css("background-color","rgb(111, 27, 40)");
			    $('.get_data').prop("disabled",false);
            }
        }else{
			$('.get_data').css("background-color","rgb(147, 148, 150)");
			$('.get_data').prop("disabled",true);
            $('#cluster_id').html('<option value="">Select Cluster</option>');
            $('#uai_id').html('<option value="">Select UAI</option>');
            $('#sub_location_id').html('<option value="">Select Sub Location</option>');
            
        }   
     });
	 $('#cluster_id').on('change', function(){
        var cluster_id=$(this).val();
        if(cluster_id != '')
        {
			$('.get_data').css("background-color","rgb(111, 27, 40)");
			$('.get_data').prop("disabled",false);
			$('#Submitted-tab').removeClass("disabledTab");
			$('#Approved-tab').removeClass("disabledTab");
			$('#Rejected-tab').removeClass("disabledTab");
            $.ajax('<?=base_url()?>reports/getContributerByCluster', {
                type: 'POST',  // http method
                data: { cluster_id: cluster_id },  // data to submit
                success: function (data) {
                    $('#contributor_id').html(data);
					$('#uai_id').html('<option value="">Select UAI</option>');
					$('#sub_location_id').html('<option value="">Select Sub Location</option>');
                }
            });
			if(survey_type=="Market Task"){
				$.ajax('<?=base_url()?>reports/getMarketsByCluster', {
					type: 'POST',  // http method
					data: { cluster_id: cluster_id },  // data to submit
					success: function (data) {
						$('#market_id').html(data);
					}
				});
			}
        } 
		else{
			if(loginrole==1){
                //empty
            }else{
                $('.get_data').css("background-color","rgb(147, 148, 150)");
			    $('.get_data').prop("disabled",true);
            }
            $('#contributor_id').html('<option value="">Select Contributor</option>');
            $('#respondent_id').html('<option value="">Select Respondent</option>');
            $('#market_id').html('<option value="">Select Market</option>');
        }   
     });

	$('#uai_id').on('change', function(){
        var uai_id=$(this).val();
		
        if(uai_id != '')
        {
			$('.get_data').css("background-color","rgb(111, 27, 40)");
			$('.get_data').prop("disabled",false);
			$('#Submitted-tab').removeClass("disabledTab");
			$('#Approved-tab').removeClass("disabledTab");
			$('#Rejected-tab').removeClass("disabledTab");
            $.ajax('<?=base_url()?>reports/getSubLocationByUai', {
                type: 'POST',  // http method
                data: { uai_id: uai_id },  // data to submit
                success: function (data) {
                    $('#sub_location_id').html(data);
                }
            });
			if(survey_type=="Market Task"){
				$.ajax('<?=base_url()?>reports/getMarketsByUai', {
					type: 'POST',  // http method
					data: { uai_id: uai_id },  // data to submit
					success: function (data) {
						$('#market_id').html(data);
                        $('#cluster_id').html('<option value="">Select Cluster</option>');
					}
				});
			}
            
        } 
		else{
			if(loginrole==1){
                //empty
            }else{
                $('.get_data').css("background-color","rgb(147, 148, 150)");
			    $('.get_data').prop("disabled",true);
            }
            $('#sub_location_id').html('<option value="">Select Sub Location</option>');
            $('#contributor_id').html('<option value="">Select Contributor</option>');
            $('#respondent_id').html('<option value="">Select Respondent</option>');
        }   
    });
	$('#sub_location_id').on('change', function(){
        var sub_location_id=$(this).val();
        if(sub_location_id != '')
        {
            $.ajax('<?=base_url()?>reports/getContributorBySubLocation', {
                type: 'POST',  // http method
                data: { sub_location_id: sub_location_id },  // data to submit
                success: function (data) {
                    $('#contributor_id').html(data);
					$('#cluster_id').html('<option value="">Select Cluster</option>');
                }
            });
        } 
		else{
            $('#contributor_id').html('<option value="">Select Contributor</option>');
            $('#respondent_id').html('<option value="">Select Respondent</option>');
        }   
    });
	$('#contributor_id').on('change', function(){
        var contributor_id=$(this).val();
		var page_id=0;
        if(contributor_id != '')
        {
            $.ajax('<?=base_url()?>reports/getRespondentByContributor', {
                type: 'POST',  // http method
                data: { contributor_id: contributor_id, page_id: page_id },  // data to submit
                success: function (data) {
                    $('#respondent_id').html(data);
                }
            });
        } 
		else{
            // $('#contributor_id').html('<option value="">Select Contributor</option>');
            $('#respondent_id').html('<option value="">Select Respondent</option>');
        }   
    });

    // for tab 2 starts from here
    $('#country_id_2').on('change', function(){
        var country_id=$(this).val();
        if(country_id != '')
        {
            $.ajax('<?=base_url()?>/reports/getClusterByCountry', {
                type: 'POST',  // http method
                data: { country_id: country_id },  // data to submit
                success: function (data) {
                    $('#cluster_id_2').html(data);
                }
            });

			$.ajax('<?=base_url()?>reports/getUaiByCountry', {
                type: 'POST',  // http method
                data: { country_id: country_id },  // data to submit
                success: function (data) {
                    $('#uai_id_2').html(data);
                }
            });
            if(loginrole==1){
                $('.get_data_2').css("background-color","rgb(111, 27, 40)");
			    $('.get_data_2').prop("disabled",false);
            }
        }else{
			$('.get_data_2').css("background-color","rgb(147, 148, 150)");
			$('.get_data_2').prop("disabled",true);
            $('#cluster_id_2').html('<option value="">Select Cluster</option>');
            $('#uai_id_2').html('<option value="">Select UAI</option>');
            $('#sub_location_id_2').html('<option value="">Select Sub Location</option>');
            
        }   
    });

    $('#uai_id_2').on('change', function(){
        var uai_id=$(this).val();
		
        if(uai_id != '')
        {
			$('.get_data_2').css("background-color","rgb(111, 27, 40)");
			$('.get_data_2').prop("disabled",false);
			$('#Submitted-tab').removeClass("disabledTab");
			$('#Approved-tab').removeClass("disabledTab");
			$('#Rejected-tab').removeClass("disabledTab");
            $.ajax('<?=base_url()?>reports/getSubLocationByUai', {
                type: 'POST',  // http method
                data: { uai_id: uai_id },  // data to submit
                success: function (data) {
                    $('#sub_location_id_2').html(data);
                    $('#cluster_id_2').html('<option value="">Select Cluster</option>');
                }
            });            
        } 
		else{
			if(loginrole==1){
                //empty
            }else{
                $('.get_data_2').css("background-color","rgb(147, 148, 150)");
			    $('.get_data_2').prop("disabled",true);
            }
            $('#sub_location_id_2').html('<option value="">Select Sub Location</option>');
        }   
    });

    $('#cluster_id_2').on('change', function(){
        var cluster_id=$(this).val();
        if(cluster_id != '')
        {
			$('.get_data_2').css("background-color","rgb(111, 27, 40)");
			$('.get_data_2').prop("disabled",false);
            $.ajax('<?=base_url()?>reports/getContributerByCluster', {
                type: 'POST',  // http method
                data: { cluster_id: cluster_id },  // data to submit
                success: function (data) {
                    // $('#contributor_id_2').html(data);
					$('#uai_id_2').html('<option value="">Select UAI</option>');
					$('#sub_location_id_2').html('<option value="">Select Sub Location</option>');
                }
            });
        } 
		else{
			if(loginrole==1){
                //empty
            }else{
                $('.get_data_2').css("background-color","rgb(147, 148, 150)");
			    $('.get_data_2').prop("disabled",true);
            }
        }   
    });
    // for tab 2 ends upto here

    // for tab 3 starts from here
    $('#country_id_3').on('change', function(){
        var country_id=$(this).val();
        if(country_id != '')
        {
            $.ajax('<?=base_url()?>/reports/getClusterByCountry', {
                type: 'POST',  // http method
                data: { country_id: country_id },  // data to submit
                success: function (data) {
                    $('#cluster_id_3').html(data);
                }
            });

			$.ajax('<?=base_url()?>reports/getUaiByCountry', {
                type: 'POST',  // http method
                data: { country_id: country_id },  // data to submit
                success: function (data) {
                    $('#uai_id_3').html(data);
                }
            });
            $.ajax('<?=base_url()?>reports/getMarketsByCountry', {
                type: 'POST',  // http method
                data: { country_id: country_id },  // data to submit
                success: function (data) {
                    $('#market_id_3').html(data);
                }
            }); 
            if(loginrole==1){
                $('.get_data_3').css("background-color","rgb(111, 27, 40)");
			    $('.get_data_3').prop("disabled",false);
            }
        }else{
			$('.get_data_3').css("background-color","rgb(147, 148, 150)");
			$('.get_data_3').prop("disabled",true);
            $('#cluster_id_3').html('<option value="">Select Cluster</option>');
            $('#uai_id_3').html('<option value="">Select UAI</option>');
            $('#sub_location_id_3').html('<option value="">Select Sub Location</option>');
            
        }   
     });

    $('#uai_id_3').on('change', function(){
        var uai_id=$(this).val();
		
        if(uai_id != '')
        {
			$('.get_data_3').css("background-color","rgb(111, 27, 40)");
			$('.get_data_3').prop("disabled",false);
			$('#Submitted-tab').removeClass("disabledTab");
			$('#Approved-tab').removeClass("disabledTab");
			$('#Rejected-tab').removeClass("disabledTab");
            $.ajax('<?=base_url()?>reports/getSubLocationByUai', {
                type: 'POST',  // http method
                data: { uai_id: uai_id },  // data to submit
                success: function (data) {
                    $('#sub_location_id_3').html(data);
                    $('#cluster_id_3').html('<option value="">Select Cluster</option>');
                }
            });     
            $.ajax('<?=base_url()?>reports/getMarketsByUai', {
                type: 'POST',  // http method
                data: { uai_id: uai_id },  // data to submit
                success: function (data) {
                    $('#market_id_3').html(data);
                    
                }
            });       
        } 
		else{
			if(loginrole==1){
                //empty
            }else{
                $('.get_data_3').css("background-color","rgb(147, 148, 150)");
			    $('.get_data_3').prop("disabled",true);
            }
            $('#sub_location_id_3').html('<option value="">Select Sub Location</option>');
        }   
    });
    $('#cluster_id_3').on('change', function(){
        var cluster_id=$(this).val();
        if(cluster_id != '')
        {
			$('.get_data_3').css("background-color","rgb(111, 27, 40)");
			$('.get_data_3').prop("disabled",false);
            $.ajax('<?=base_url()?>reports/getContributerByCluster', {
                type: 'POST',  // http method
                data: { cluster_id: cluster_id },  // data to submit
                success: function (data) {
                    // $('#contributor_id_3').html(data);
					$('#uai_id_3').html('<option value="">Select UAI</option>');
					$('#sub_location_id_3').html('<option value="">Select Sub Location</option>');
                }
            });
            
            //calling markets load
            $.ajax('<?=base_url()?>reports/getMarketsByCluster', {
                type: 'POST',  // http method
                data: { cluster_id: cluster_id },  // data to submit
                success: function (data) {
                    $('#market_id_3').html(data);
                }
            });
			
        } 
		else{
			if(loginrole==1){
                //empty
            }else{
                $('.get_data_3').css("background-color","rgb(147, 148, 150)");
			    $('.get_data_3').prop("disabled",true);
            }
        }   
    });
    function getPointCategoryName(point, dimension) {
        var series = point.series,
            isY = dimension === 'y',
            axis = series[isY ? 'yAxis' : 'xAxis'];
        return axis.categories[point[isY ? 'y' : 'x']];
    }
    // for tab 3 ends upto here

    
    // for tab 4 starts from here
    $('#country_id_4').on('change', function(){
        var country_id=$(this).val();
        if(country_id != '')
        {
            $.ajax('<?=base_url()?>/reports/getClusterByCountry', {
                type: 'POST',  // http method
                data: { country_id: country_id },  // data to submit
                success: function (data) {
                    $('#cluster_id_4').html(data);
                }
            });

			$.ajax('<?=base_url()?>reports/getUaiByCountry', {
                type: 'POST',  // http method
                data: { country_id: country_id },  // data to submit
                success: function (data) {
                    $('#uai_id_4').html(data);
                }
            });
            if(loginrole==1){
                $('.get_data_4').css("background-color","rgb(111, 27, 40)");
			    $('.get_data_4').prop("disabled",false);
            }
        }else{
			$('.get_data_4').css("background-color","rgb(147, 148, 150)");
			$('.get_data_4').prop("disabled",true);
            $('#cluster_id_4').html('<option value="">Select Cluster</option>');
            $('#uai_id_4').html('<option value="">Select UAI</option>');
            $('#sub_location_id_4').html('<option value="">Select Sub Location</option>');
            
        }   
     });

    $('#uai_id_4').on('change', function(){
        var uai_id=$(this).val();
		
        if(uai_id != '')
        {
			$('.get_data_4').css("background-color","rgb(111, 27, 40)");
			$('.get_data_4').prop("disabled",false);
			$('#Submitted-tab').removeClass("disabledTab");
			$('#Approved-tab').removeClass("disabledTab");
			$('#Rejected-tab').removeClass("disabledTab");
            $.ajax('<?=base_url()?>reports/getSubLocationByUai', {
                type: 'POST',  // http method
                data: { uai_id: uai_id },  // data to submit
                success: function (data) {
                    $('#sub_location_id_4').html(data);
                    $('#cluster_id_4').html('<option value="">Select Cluster</option>');
                }
            });            
        } 
		else{
			if(loginrole==1){
                //empty
            }else{
                $('.get_data_4').css("background-color","rgb(147, 148, 150)");
			    $('.get_data_4').prop("disabled",true);
            }
            $('#sub_location_id_4').html('<option value="">Select Sub Location</option>');
        }   
    });
    $('#cluster_id_4').on('change', function(){
        var cluster_id=$(this).val();
        if(cluster_id != '')
        {
			$('.get_data_4').css("background-color","rgb(111, 27, 40)");
			$('.get_data_4').prop("disabled",false);
            $.ajax('<?=base_url()?>reports/getContributerByCluster', {
                type: 'POST',  // http method
                data: { cluster_id: cluster_id },  // data to submit
                success: function (data) {
                    // $('#contributor_id_4').html(data);
					$('#uai_id_4').html('<option value="">Select UAI</option>');
					$('#sub_location_id_4').html('<option value="">Select Sub Location</option>');
                }
            });
        } 
		else{
			if(loginrole==1){
                //empty
            }else{
                $('.get_data_4').css("background-color","rgb(147, 148, 150)");
			    $('.get_data_4').prop("disabled",true);
            }
        }   
    });
    // for tab 4 ends upto here

    
    // for tab 5 starts from here
    $('#country_id_5').on('change', function(){
        var country_id=$(this).val();
        if(country_id != '')
        {
            $.ajax('<?=base_url()?>/reports/getClusterByCountry', {
                type: 'POST',  // http method
                data: { country_id: country_id },  // data to submit
                success: function (data) {
                    $('#cluster_id_5').html(data);
                }
            });

			$.ajax('<?=base_url()?>reports/getUaiByCountry', {
                type: 'POST',  // http method
                data: { country_id: country_id },  // data to submit
                success: function (data) {
                    $('#uai_id_5').html(data);
                }
            });
            if(loginrole==1){
                $('.get_data_5').css("background-color","rgb(111, 27, 40)");
			    $('.get_data_5').prop("disabled",false);
            }
        }else{
			$('.get_data_5').css("background-color","rgb(147, 148, 150)");
			$('.get_data_5').prop("disabled",true);
            $('#cluster_id_5').html('<option value="">Select Cluster</option>');
            $('#uai_id_5').html('<option value="">Select UAI</option>');
            $('#sub_location_id_5').html('<option value="">Select Sub Location</option>');
            
        }   
     });

    $('#uai_id_5').on('change', function(){
        var uai_id=$(this).val();
		
        if(uai_id != '')
        {
			$('.get_data_5').css("background-color","rgb(111, 27, 40)");
			$('.get_data_5').prop("disabled",false);
			$('#Submitted-tab').removeClass("disabledTab");
			$('#Approved-tab').removeClass("disabledTab");
			$('#Rejected-tab').removeClass("disabledTab");
            $.ajax('<?=base_url()?>reports/getSubLocationByUai', {
                type: 'POST',  // http method
                data: { uai_id: uai_id },  // data to submit
                success: function (data) {
                    $('#sub_location_id_5').html(data);
                }
            });            
        } 
		else{
			if(loginrole==1){
                //empty
            }else{
                $('.get_data_5').css("background-color","rgb(147, 148, 150)");
			    $('.get_data_5').prop("disabled",true);
            }
            $('#sub_location_id_5').html('<option value="">Select Sub Location</option>');
        }   
    });
    $('#cluster_id_5').on('change', function(){
        var cluster_id=$(this).val();
        if(cluster_id != '')
        {
			$('.get_data_5').css("background-color","rgb(111, 27, 40)");
			$('.get_data_5').prop("disabled",false);
            $.ajax('<?=base_url()?>reports/getContributerByCluster', {
                type: 'POST',  // http method
                data: { cluster_id: cluster_id },  // data to submit
                success: function (data) {
                    // $('#contributor_id_5').html(data);
					$('#uai_id_5').html('<option value="">Select UAI</option>');
					$('#sub_location_id_5').html('<option value="">Select Sub Location</option>');
                }
            });
        } 
		else{
			if(loginrole==1){
                //empty
            }else{
                $('.get_data_5').css("background-color","rgb(147, 148, 150)");
			    $('.get_data_5').prop("disabled",true);
            }
        }   
    });
    // for tab 5 ends upto here

        /*  Sagar wrote code for loading dashboards from here*/

        function getSurveyDeatilsViewT1(){
            // alert("called");
            // showLoader();
            var country_id=$('select[name="country_id"]').val();
            var uai_id=$('select[name="uai_id"]').val();
            var sub_location_id=$('select[name="sub_location_id"]').val();
            var cluster_id=$('select[name="cluster_id"]').val();
            var start_date=$('input[name="start_date"]').val();
            var end_date=$('input[name="end_date"]').val();
            
            var query_data = {
                // filter_survey: filter,
                country_id : country_id,
                uai_id : uai_id,
                sub_location_id : sub_location_id,
                cluster_id : cluster_id,
                // start_date : formatDate(start_date),
                // end_date : formatDate(end_date)
                start_date : start_date,
                end_date : end_date

            };
                $('.div_survey_deatils_view').html('<h4 class="text-center loading">Please Wait. Getting Data</h4>');
                $.ajax({
                    url : "<?php echo base_url(); ?>dashboard/get_users_1/",
                    data : query_data,
                    type : "POST",
                    dataType : "JSON",
                    error:function(){	            	
                        // $('#beneficiary_data').find('.loading').remove();
                        // $.toast({
                        // 	heading: 'Network Error!',
                        // 	text: 'Could not establish connection to server. Please refresh the page and try again.',
                        // 	icon: 'error'
                        // });
                    },
                    success:function(response){
                        if(response.status == 1){
                            var HTML_GENERAL = `
                            <div class="row mt-4">
                                <div class="col-sm-12 col-md-12 col-lg-12">
                                    <!-- Contributor Graphs start -->
                                    <h4>Contributors </h4></br>
                                    <div class="row mt-4">
                                        <div class="col-sm-12 col-md-12 col-lg-12">
                                            <div class="card border-0 card-shadow">
                                                <div class="card-body">
                                                    <h4 class="chart-title">UAI wise</h4>
                                                    <div class="map_height" id="number_of_uai_contributors" style="width:100%;height: 300px;"> </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-12 col-md-12 col-lg-12">
                                            <div class="card border-0 card-shadow">
                                                <div class="card-body">
                                                    <h4 class="chart-title">Cluster wise</h4>
                                                    <div class="map_height" id="number_of_cluster_contributors" style="width:100%;height: 300px;"> </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mt-4">
                                        <div class="col-sm-12 col-md-6 col-lg-6">
                                            <div class="card border-0 card-shadow">
                                                <div class="card-body">
                                                    <h4 class="chart-title">Contributors - Status</h4>
                                                    <div class="map_height" id="number_of_contributors" style="width:100%;height: 300px;"> </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-12 col-md-6 col-lg-6">
                                            <div class="card border-0 card-shadow">
                                                <div class="card-body">
                                                    <h4 class="chart-title">Rejected Reasons</h4>
                                                    <div class="map_height" id="rejected_reasons" style="width:100%;height: 300px;"> </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row mt-4">
                                        <div class="col-sm-12 col-md-6 col-lg-6">
                                            <div class="card border-0 card-shadow">
                                                <div class="card-body">
                                                    <h4 class="chart-title">Gender</h4>
                                                    <div class="map_height" id="gender_dashboard" style="width:100%;height: 300px;"> </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-12 col-md-6 col-lg-6">
                                            <div class="card border-0 card-shadow">
                                                <div class="card-body">
                                                    <h4 class="chart-title">Account Details - Status</h4>
                                                    <div class="map_height" id="account_details_status" style="width:100%;height: 300px;"> </div>
                                                </div>
                                            </div>
                                        </div>
                                        
                                    </div>
                                    <div class="row mt-4">
                                        <div class="col-sm-12 col-md-6 col-lg-6">
                                            <div class="card border-0 card-shadow">
                                                <div class="card-body">
                                                    <h4 class="chart-title">Highest level of Education</h4>
                                                    <div class="map_height" id="highest_education" style="width:100%;height: 300px;"> </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-12 col-md-6 col-lg-6">
                                            <div class="card border-0 card-shadow">
                                                <div class="card-body">
                                                    <h4 class="chart-title">Primary Occupation</h4>
                                                    <div class="map_height" id="primary_occupation" style="width:100%;height: 300px;"> </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- contributor graph end -->
                                    <!-- Respondent graph start -->
                                    <h4> Respondents </h4></br>
                                    <div class="row mt-4">
                                        <div class="col-sm-12 col-md-12 col-lg-12">
                                            <div class="card border-0 card-shadow">
                                                <div class="card-body">
                                                    <h4 class="chart-title">UAI wise</h4>
                                                    <div class="map_height" id="number_of_uai_respondents" style="width:100%;height: 300px;"> </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-12 col-md-12 col-lg-12">
                                            <div class="card border-0 card-shadow">
                                                <div class="card-body">
                                                    <h4 class="chart-title">Cluster wise</h4>
                                                    <div class="map_height" id="number_of_cluster_respondents" style="width:100%;height: 300px;"> </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mt-4">
                                        <div class="col-sm-12 col-md-6 col-lg-6">
                                            <div class="card border-0 card-shadow">
                                                <div class="card-body">
                                                    <h4 class="chart-title">Status</h4>
                                                    <div class="map_height" id="respondent_dashboard" style="width:100%;height: 300px;"> </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-12 col-md-6 col-lg-6">
                                            <div class="card border-0 card-shadow">
                                                <div class="card-body">
                                                    <h4 class="chart-title">Household Members - Age</h4>
                                                    <div class="map_height" id="household_member" style="width:100%;height: 300px;"> </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row mt-4">
                                        <div class="col-sm-12 col-md-6 col-lg-6">
                                            <div class="card border-0 card-shadow">
                                                <div class="card-body">
                                                    <h4 class="chart-title">Household Head - Gender</h4>
                                                    <div class="map_height" id="household_hh_gender" style="width:100%;height: 300px;"> </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-12 col-md-6 col-lg-6">
                                            <div class="card border-0 card-shadow">
                                                <div class="card-body">
                                                    <h4 class="chart-title">Household Head - Age</h4>
                                                    <div class="map_height" id="household_hh_age" style="width:100%;height: 300px;"> </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row mt-4">
                                        <div class="col-sm-12 col-md-6 col-lg-6">
                                            <div class="card border-0 card-shadow">
                                                <div class="card-body">
                                                    <h4 class="chart-title">Household members suffering from Disability, Chronic Illness</h4>
                                                    <div class="map_height" id="houshold_profile" style="width:100%;height: 300px;"> </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-12 col-md-6 col-lg-6">
                                            <div class="card border-0 card-shadow">
                                                <div class="card-body">
                                                    <h4 class="chart-title">Children</h4>
                                                    <div class="map_height" id="household_children_gender" style="width:100%;height: 300px;"> </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Respondent graph start -->
                                    <h4> Household Livestock </h4></br>
                                    <div class="row mt-4">
                                        <div class="col-sm-12 col-md-12 col-lg-12">
                                            <div class="card border-0 card-shadow">
                                                <div class="card-body">
                                                    <h4 class="chart-title">UAI wise</h4>
                                                    <div class="map_height" id="number_of_uai_livestocks" style="width:100%;height: 300px;"> </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-12 col-md-12 col-lg-12">
                                            <div class="card border-0 card-shadow">
                                                <div class="card-body">
                                                    <h4 class="chart-title">Cluster wise</h4>
                                                    <div class="map_height" id="number_of_cluster_livestocks" style="width:100%;height: 300px;"> </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mt-4">
                                        <div class="col-sm-12 col-md-6 col-lg-6">
                                            <div class="card border-0 card-shadow">
                                                <div class="card-body">
                                                    <h4 class="chart-title">Livestock (Number)</h4>
                                                    <div class="map_height" id="household_Livestock" style="width:100%;height: 300px;"> </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>                            
                                `;
                            $('.div_survey_deatils_view').html(HTML_GENERAL);
                            monthsimple_barchart('number_of_uai_contributors', response.fielddata_uai_contributor_number, 'Location UAI wise No.of Contributors');
                            monthsimple_barchart('number_of_cluster_contributors', response.fielddata_cluster_contributor_number, 'Location cluster wise No.of Contributors');
                            monthsimple_piechart('number_of_contributors', response.fielddata_contributor_number, 'No.of Contributors');
                            monthsimple_piechart('gender_dashboard', response.fielddata_gender, 'Gender');
                            monthsimple_piechart('rejected_reasons', response.fielddata_rejected_reasons, 'Rejected Reasons');
                            monthsimple_piechart('account_details_status', response.fielddata_account_details_status, 'Account Details Status');
                            monthsimple_piechart('highest_education', response.fielddata_highest_education, 'Highest level of education');
                            monthsimple_piechart('primary_occupation', response.fielddata_primary_occupation, 'Primary Occupation');
                            monthsimple_barchart('number_of_uai_respondents', response.fielddata_uai_respondent_number, 'Location UAI wise No.of Respondents');
                            monthsimple_barchart('number_of_cluster_respondents', response.fielddata_cluster_respondent_number, 'Location cluster wise No.of Respondents');
                            monthsimple_piechart('respondent_dashboard', response.fielddata_respondent_dashboard, 'Respondents');
                            monthsimple_piechart('household_member', response.fielddata_household_member, 'Household Members');
                            monthsimple_piechart('household_hh_gender', response.fielddata_household_hh_gender, 'Household Head Gender');
                            monthsimple_piechart('household_hh_age', response.fielddata_household_hh_age, 'Household Head Age');
                            // monthsimple_piechart('houshold_profile', response.fielddata_houshold_profile, 'HH Disability');
                            monthsimple_grouped_yesno_barchart('houshold_profile', response.fielddata_houshold_profile, 'HH Disability, Chronic');
                            monthsimple_piechart('household_children_gender', response.fielddata_household_children_gender, 'Child Gender');
                            monthsimple_barchart('number_of_uai_livestocks', response.fielddata_uai_livestock_number, 'Location UAI wise No.of Livestocks');
                            monthsimple_grouped_barchart('number_of_cluster_livestocks', response.fielddata_cluster_livestock_number, 'Location cluster wise No.of Livestocks');
                            monthsimple_piechart('household_Livestock', response.fielddata_household_Livestock, 'Household Head');
                        }
                    }
                }).always(function(response) {
                // setTimeout(() => hideLoader(), 1000);
            });
        }

        function getSurveyDeatilsViewT2(){
            // alert("called");
            // showLoader();
            var country_id=$('select[name="country_id_2"]').val();
            var uai_id=$('select[name="uai_id_2"]').val();
            var sub_location_id=$('select[name="sub_location_id_2"]').val();
            var cluster_id=$('select[name="cluster_id_2"]').val();
            var start_date=$('input[name="start_date_2"]').val();
            var end_date=$('input[name="end_date_2"]').val();
            
            var query_data = {
                // filter_survey: filter,
                country_id : country_id,
                uai_id : uai_id,
                sub_location_id : sub_location_id,
                cluster_id : cluster_id,
                // start_date : formatDate(start_date),
                // end_date : formatDate(end_date)
                start_date : start_date,
                end_date : end_date

            };
                $('.div_survey_deatils_t2_view').html('<h4 class="text-center loading">Please Wait. Getting Data</h4>');
                $.ajax({
                    url : "<?php echo base_url(); ?>dashboard/get_users_2/",
                    data : query_data,
                    type : "POST",
                    dataType : "JSON",
                    error:function(){	            	
                        // $('#beneficiary_data').find('.loading').remove();
                        // $.toast({
                        // 	heading: 'Network Error!',
                        // 	text: 'Could not establish connection to server. Please refresh the page and try again.',
                        // 	icon: 'error'
                        // });
                    },
                    success:function(response){
                        if(response.status == 1){
                            var HTML_GENERAL = `
                                    <!-- Milk Production start from here -->
                                    <h4>Milk Production </h4></br>
                                        <div class="row mt-4">
                                            <div class="col-sm-12 col-md-12 col-lg-12">
                                                <div class="card border-0 card-shadow">
                                                    <div class="card-body">
                                                        <h4 class="chart-title">Animals milked</h4>
                                                        <div class="map_height" id="number_of_animals"
                                                            style="width:100%;height: 260px;">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mt-4">
                                            <div class="col-sm-12 col-md-6 col-lg-6">
                                                <div class="card border-0 card-shadow">
                                                    <div class="card-body">
                                                        <h4 class="chart-title">Milk Production & Sale (in Litres)</h4>
                                                        <div class="map_height" id="average_liters_milk_per_day"
                                                            style="width:100%;height: 260px;">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-12 col-md-6 col-lg-6">
                                                <div class="card border-0 card-shadow">
                                                    <div class="card-body">
                                                        <h4 class="chart-title">Average Selling Price (per Litre)</h4>
                                                        <div class="map_height" id="production_volume"
                                                            style="width:100%;height: 260px;">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                        </div>
                                    <!-- Milk Production End upto here -->
                                    <!-- Body Condition & Weight start from here -->
                                        <h4>Body Condition & Weight</h4></br>
                                        <div class="row mt-4">
                                            <div class="col-sm-12 col-md-6 col-lg-6">
                                                <div class="card border-0 card-shadow">
                                                    <div class="card-body">
                                                        <h4 class="chart-title">Age Distribution</h4>
                                                        <div class="map_height" id="animal_age"
                                                            style="width:100%;height: 260px;">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>                                            
                                        </div>
                                        <div class="row mt-4">
                                            <div class="col-sm-12 col-md-6 col-lg-6">
                                                <div class="card border-0 card-shadow">
                                                    <div class="card-body">
                                                        <h4 class="chart-title">Gender Distribution</h4>
                                                        <div class="map_height" id="animal_gender_1"
                                                            style="width:100%;height: 260px;">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-12 col-md-6 col-lg-6">
                                                <div class="card border-0 card-shadow">
                                                    <div class="card-body">
                                                        <h4 class="chart-title">Gender Distribution</h4>
                                                        <div class="map_height" id="animal_gender_2"
                                                            style="width:100%;height: 260px;">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row mt-4">
                                            <div class="col-sm-12 col-md-6 col-lg-6">
                                                <div class="card border-0 card-shadow">
                                                    <div class="card-body">
                                                        <h4 class="chart-title">Body Condition</h4>
                                                        <div class="map_height" id="animal_body_condition1"
                                                            style="width:100%;height: 260px;">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-12 col-md-6 col-lg-6">
                                                <div class="card border-0 card-shadow">
                                                    <div class="card-body">
                                                        <h4 class="chart-title">Body Condition</h4>
                                                        <div class="map_height" id="animal_body_condition2"
                                                            style="width:100%;height: 260px;">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <!-- Body Condition & Weight End upto here -->
                                    <!-- MUAC start from here -->
                                        <h4>MUAC </h4></br>
                                        <div class="row mt-4">
                                            <div class="col-sm-12 col-md-6 col-lg-6">
                                                <div class="card border-0 card-shadow">
                                                    <div class="card-body">
                                                        <h4 class="chart-title">MUAC Distribution</h4>
                                                        <div class="map_height" id="measurement_color"
                                                            style="width:100%;height: 260px;">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-12 col-md-6 col-lg-6">
                                                <div class="card border-0 card-shadow">
                                                    <div class="card-body">
                                                        <h4 class="chart-title">MUAC Measurement Distribution</h4>
                                                        <div class="map_height"
                                                            id="muac_measurement"
                                                            style="width:100%;height: 260px;">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <!-- MUAC End upto here -->
                                    <!-- Livestock start from here -->
                                    <h4>Livestock</h4></br>
                                        <div class="row mt-4">
                                            <div class="col-sm-12 col-md-6 col-lg-6">
                                                <div class="card border-0 card-shadow">
                                                    <div class="card-body">
                                                        <h4 class="chart-title">Animal Distribution</h4>
                                                        <div class="map_height" id="livestock_animal"
                                                            style="width:100%;height: 260px;">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-12 col-md-6 col-lg-6">
                                                <div class="card border-0 card-shadow">
                                                    <div class="card-body">
                                                        <h4 class="chart-title">Age Distribution</h4>
                                                        <div class="map_height" id="animal_type"
                                                            style="width:100%;height: 260px;">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row mt-4">
                                            
                                            
                                            <div class="col-sm-12 col-md-12 col-lg-12">
                                                <div class="card border-0 card-shadow">
                                                    <div class="card-body">
                                                        <h4 class="chart-title">Births & Deaths</h4>
                                                        <div class="map_height" id="animal_births_deaths"
                                                            style="width:100%;height: 260px;">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row mt-4">  
                                            <div class="col-sm-12 col-md-12 col-lg-12">
                                                <div class="card border-0 card-shadow">
                                                    <div class="card-body">
                                                        <h4 class="chart-title">Main cause of animal death</h4>
                                                        <div class="map_height" id="animal_death_cause" style="width:100%;height: 300px;"> </div>
                                                    </div>
                                                </div>
                                            </div> 
                                            
                                        </div>

                                        <div class="row mt-4">
                                            <div class="col-sm-12 col-md-6 col-lg-6">
                                                <div class="card border-0 card-shadow">
                                                    <div class="card-body">
                                                        <h4 class="chart-title">Sales</h4>
                                                        <div class="map_height" id="animal_sales"
                                                            style="width:100%;height: 260px;">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-12 col-md-6 col-lg-6">
                                                <div class="card border-0 card-shadow">
                                                    <div class="card-body">
                                                        <h4 class="chart-title">Purchases</h4>
                                                        <div class="map_height" id="animal_purchases"
                                                            style="width:100%;height: 260px;">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        
                                    <!-- Livestock End upto here --> 
                                    
                                    <!-- RCSI graphs start from here -->
                                    <h4>RCSI</h4></br>
                                        <div class="row mt-4">
                                            <div class="col-sm-12 col-md-12 col-lg-12">
                                                <div class="card border-0 card-shadow">
                                                    <div class="card-body">
                                                        <h4 class="chart-title">Proportion of women/caregivers consuming of food groups</h4>
                                                        <div class="map_height" id="rcsi_graph"
                                                            style="width:100%;height: 450px;">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div> 
                                            <div class="col-sm-12 col-md-12 col-lg-12">
                                                <div class="card border-0 card-shadow">
                                                    <div class="card-body">
                                                        <h4 class="chart-title">Proportion of women/caregivers consuming 'n' number of food groups</h4>
                                                        <div class="map_height" id="rcsi_stacked_bar"
                                                            style="width:100%;height: 450px;">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>   
                                        </div>                         
                                `;
                            $('.div_survey_deatils_t2_view').html(HTML_GENERAL);
                            monthsimple_barchart('number_of_animals', response.fielddata_number_of_animals, 'Number');
                            monthsimple_grouped_barchart('average_liters_milk_per_day', response.fielddata_milked_sold_data, 'Number');
                            // monthsimple_bar_linechart('average_liters_milk_per_day', response.bardata_sum_liters_milk_per_day, response.linedata_sum_liters_selling_price,'In Local Currency');
                            // monthsimple_barchart('average_Selling_Price', response.fielddata_average_Selling_Price, 'Average Selling Price');
                            // monthsimple_barchart('production_volume', response.fielddata_production_volume, 'Litres');
                            simple_line_graph('production_volume', response.linedata_sum_liters_selling_price, 'in Local Currency');
                            // monthsimple_grouped_barchart('animal_gender', response.fielddata_animal_gender, 'Animal Gender');
                            monthsimple_grouped_barchart_11('animal_gender_1', response.fielddata_animal_gender_1, 'Number');
                            monthsimple_grouped_barchart_22('animal_gender_2', response.fielddata_animal_gender_2, 'Number');
                            monthsimple_grouped_barchart('animal_age', response.fielddata_animal_age, 'Number');
                            // monthsimple_grouped_barchart('animal_body_condition', response.fielddata_animal_body_condition, 'Animal Body Condition');
                            monthsimple_grouped_barchart_1('animal_body_condition1', response.fielddata_animal_body_condition1, 'Number');
                            monthsimple_grouped_barchart_2('animal_body_condition2', response.fielddata_animal_body_condition2, 'Number');
                            monthsimple_barchart('measurement_color', response.fielddata_measurement_color, 'Number of Children');
                            monthsimple_barchart('muac_measurement', response.fielddata_muac_measurement, 'Number of Children');
                            monthsimple_barchart('livestock_animal', response.fielddata_livestock_animal, 'Number');
                            // monthsimple_barchart_categories('livestock_animal', response.fielddata_livestock_animal, 'Number',response.get_lkp_herd_type_list);
                            monthsimple_grouped_barchart('animal_type', response.fielddata_animal_type, 'Number');
                            // monthsimple_grouped_barchart('animal_births', response.fielddata_animal_births, 'Animal Births');
                            // monthsimple_grouped_barchart('animal_death', response.fielddata_animal_death, 'Animal Deaths');
                            monthsimple_grouped_barchart('animal_births_deaths', response.fielddata_animal_births_deaths, 'Number');
                            // monthsimple_piechart('animal_death_cause', response.fielddata_animal_death_cause, 'Number');
                            monthsimple_grouped_barchart('animal_death_cause', response.fielddata_animal_death_cause, 'Number');
                            monthsimple_barchart('animal_sales', response.fielddata_animal_sales, 'Animal sales');
                            monthsimple_barchart('animal_purchases', response.fielddata_animal_purchases, 'Animal purchases');
                            monthsimple_heat_map1(response.fielddata_rcsi[0]['month_list'], response.fielddata_rcsi[0]['category_list'], 'rcsi_graph', response.fielddata_rcsi[0]['data'], 'RCSI Graph');
                            monthstacked_grouped_barchart('rcsi_stacked_bar', response.fielddata_rcsi_stacked[0]['month_list'], response.fielddata_rcsi_stacked[0]['data1'], response.fielddata_rcsi_stacked[0]['data2'], 'RCSI Graph');
                        }
                    }
                }).always(function(response) {
                // setTimeout(() => hideLoader(), 1000);
            });
        }

        function getSurveyDeatilsViewT3(){
            // alert("called");
            // showLoader();
            var country_id=$('select[name="country_id_3"]').val();
            var uai_id=$('select[name="uai_id_3"]').val();
            var sub_location_id=$('select[name="sub_location_id_3"]').val();
            var cluster_id=$('select[name="cluster_id_3"]').val();
            var market_id=$('select[name="market_id_3"]').val();
            var start_date=$('input[name="start_date_3"]').val();
            var end_date=$('input[name="end_date_3"]').val();
            
            var query_data = {
                // filter_survey: filter,
                country_id : country_id,
                market_id : market_id,
                uai_id : uai_id,
                sub_location_id : sub_location_id,
                cluster_id : cluster_id,
                // start_date : formatDate(start_date),
                // end_date : formatDate(end_date)
                start_date : start_date,
                end_date : end_date

            };
                $('.market_tab_3_view_details').html('<h4 class="text-center loading">Please Wait. Getting Data</h4>');
                $.ajax({
                    url : "<?php echo base_url(); ?>dashboard/get_market_tab_3/",
                    data : query_data,
                    type : "POST",
                    dataType : "JSON",
                    error:function(){	            	
                        // $('#beneficiary_data').find('.loading').remove();
                        // $.toast({
                        // 	heading: 'Network Error!',
                        // 	text: 'Could not establish connection to server. Please refresh the page and try again.',
                        // 	icon: 'error'
                        // });
                    },
                    success:function(response){
                        if(response.status == 1){
                            var HTML_GENERAL = `
                                <!-- Prices of Index commodities  heat map graphs start from here -->
                                    <h4>Prices of Index commodities</h4></br>
                                    <h5>Camel Milk</h5></br>
                                        <div class="row mt-4">                                            
                                            <div class="col-sm-12 col-md-6 col-lg-6">
                                                <div class="card border-0 card-shadow">
                                                    <div class="card-body">
                                                        <h4 class="chart-title">UAI Distribution</h4>
                                                        <div class="map_height" id="camel_mlilk_uai"
                                                            style="width:100%;height: 460px;">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-12 col-md-6 col-lg-6">
                                                <div class="card border-0 card-shadow">
                                                    <div class="card-body">
                                                        <h4 class="chart-title">Cluster Distribution</h4>
                                                        <div class="map_height" id="camel_mlilk_cluster"
                                                            style="width:100%;height: 460px;">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <h5>Cattle Milk</h5></br>
                                        <div class="row mt-4">                                            
                                            <div class="col-sm-12 col-md-6 col-lg-6">
                                                <div class="card border-0 card-shadow">
                                                    <div class="card-body">
                                                        <h4 class="chart-title">UAI Distribution</h4>
                                                        <div class="map_height" id="cattle_milk_uai"
                                                            style="width:100%;height: 460px;">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-12 col-md-6 col-lg-6">
                                                <div class="card border-0 card-shadow">
                                                    <div class="card-body">
                                                        <h4 class="chart-title">Cluster Distribution</h4>
                                                        <div class="map_height" id="cattle_milk_cluster"
                                                            style="width:100%;height: 460px;">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <h5>Maize Grain </h5></br>
                                        <div class="row mt-4">                                            
                                            <div class="col-sm-12 col-md-6 col-lg-6">
                                                <div class="card border-0 card-shadow">
                                                    <div class="card-body">
                                                        <h4 class="chart-title">UAI Distribution</h4>
                                                        <div class="map_height" id="maize_grain_uai"
                                                            style="width:100%;height: 460px;">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-12 col-md-6 col-lg-6">
                                                <div class="card border-0 card-shadow">
                                                    <div class="card-body">
                                                        <h4 class="chart-title">Cluster Distribution</h4>
                                                        <div class="map_height" id="maize_grain_cluster"
                                                            style="width:100%;height: 460px;">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <h5>Sorghum Grain</h5></br>
                                        <div class="row mt-4">                                            
                                            <div class="col-sm-12 col-md-6 col-lg-6">
                                                <div class="card border-0 card-shadow">
                                                    <div class="card-body">
                                                        <h4 class="chart-title">UAI Distribution</h4>
                                                        <div class="map_height" id="sorghum_uai"
                                                            style="width:100%;height: 460px;">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-12 col-md-6 col-lg-6">
                                                <div class="card border-0 card-shadow">
                                                    <div class="card-body">
                                                        <h4 class="chart-title">Cluster Distribution</h4>
                                                        <div class="map_height" id="sorghum_cluster"
                                                            style="width:100%;height: 460px;">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <h5>Wheat Grain</h5></br>
                                        <div class="row mt-4">                                            
                                            <div class="col-sm-12 col-md-6 col-lg-6">
                                                <div class="card border-0 card-shadow">
                                                    <div class="card-body">
                                                        <h4 class="chart-title">UAI Distribution</h4>
                                                        <div class="map_height" id="wheat_uai"
                                                            style="width:100%;height: 460px;">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-12 col-md-6 col-lg-6">
                                                <div class="card border-0 card-shadow">
                                                    <div class="card-body">
                                                        <h4 class="chart-title">Cluster Distribution</h4>
                                                        <div class="map_height" id="wheat_cluster"
                                                            style="width:100%;height: 460px;">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <h5>Sugar</h5></br>
                                        <div class="row mt-4">                                            
                                            <div class="col-sm-12 col-md-6 col-lg-6">
                                                <div class="card border-0 card-shadow">
                                                    <div class="card-body">
                                                        <h4 class="chart-title">UAI Distribution</h4>
                                                        <div class="map_height" id="sugar_uai"
                                                            style="width:100%;height: 460px;">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-12 col-md-6 col-lg-6">
                                                <div class="card border-0 card-shadow">
                                                    <div class="card-body">
                                                        <h4 class="chart-title">Cluster Distribution</h4>
                                                        <div class="map_height" id="sugar_cluster"
                                                            style="width:100%;height: 460px;">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <h5>Unpacked regular rice</h5></br>
                                        <div class="row mt-4">                                            
                                            <div class="col-sm-12 col-md-6 col-lg-6">
                                                <div class="card border-0 card-shadow">
                                                    <div class="card-body">
                                                        <h4 class="chart-title">UAI Distribution</h4>
                                                        <div class="map_height" id="rice_uai"
                                                            style="width:100%;height: 460px;">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-12 col-md-6 col-lg-6">
                                                <div class="card border-0 card-shadow">
                                                    <div class="card-body">
                                                        <h4 class="chart-title">Cluster Distribution</h4>
                                                        <div class="map_height" id="rice_cluster"
                                                            style="width:100%;height: 460px;">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <!-- Livestock Prices & Quality start from here -->
                                    <h4>Livestock Prices & Quality </h4></br>
                                        <div class="row mt-4">
                                            <div class="col-sm-12 col-md-6 col-lg-6">
                                                <div class="card border-0 card-shadow">
                                                    <div class="card-body">
                                                        <h4 class="chart-title">Animals for Trade</h4>
                                                        <div class="map_height" id="animal_for_trade_1"
                                                            style="width:100%;height: 260px;">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-12 col-md-6 col-lg-6">
                                                <div class="card border-0 card-shadow">
                                                    <div class="card-body">
                                                        <h4 class="chart-title">Animals for Trade</h4>
                                                        <div class="map_height" id="animal_for_trade_2"
                                                            style="width:100%;height: 260px;">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mt-4">
                                            <div class="col-sm-12 col-md-12 col-lg-12">
                                                <div class="card border-0 card-shadow">
                                                    <div class="card-body">
                                                        <h4 class="chart-title">Animal Gender</h4>
                                                        <div class="map_height" id="livestock_animal_gender"
                                                            style="width:100%;height: 260px;">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <h4>Final Selling Price</h4></br>
                                        <div class="row mt-4">
                                            <div class="col-sm-12 col-md-12 col-lg-12">
                                                <div class="card border-0 card-shadow">
                                                    <div class="card-body">
                                                        <h4 class="chart-title">Camel</h4>
                                                        <div class="map_height" id="camel_selling_price"
                                                            style="width:100%;height: 260px;">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mt-4">
                                            <div class="col-sm-12 col-md-12 col-lg-12">
                                                <div class="card border-0 card-shadow">
                                                    <div class="card-body">
                                                        <h4 class="chart-title">Cattle</h4>
                                                        <div class="map_height" id="cattle_selling_price"
                                                            style="width:100%;height: 260px;">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mt-4">
                                            <div class="col-sm-12 col-md-12 col-lg-12">
                                                <div class="card border-0 card-shadow">
                                                    <div class="card-body">
                                                        <h4 class="chart-title">Goats</h4>
                                                        <div class="map_height" id="goats_selling_price"
                                                            style="width:100%;height: 260px;">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mt-4">
                                            <div class="col-sm-12 col-md-12 col-lg-12">
                                                <div class="card border-0 card-shadow">
                                                    <div class="card-body">
                                                        <h4 class="chart-title">Sheep</h4>
                                                        <div class="map_height" id="sheep_selling_price"
                                                            style="width:100%;height: 260px;">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <!-- Livestock Prices & Quality End upto here --> 
                                    <!-- Livestock Volumes start from here -->
                                    <h4>Livestock Volumes </h4></br>
                                        <div class="row mt-4">
                                            <div class="col-sm-12 col-md-12 col-lg-12">
                                                <div class="card border-0 card-shadow">
                                                    <div class="card-body">
                                                        <h4 class="chart-title">Camel</h4>
                                                        <div class="map_height" id="camel_volumes"
                                                            style="width:100%;height: 260px;">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-12 col-md-12 col-lg-12">
                                                <div class="card border-0 card-shadow">
                                                    <div class="card-body">
                                                        <h4 class="chart-title">Cattle</h4>
                                                        <div class="map_height" id="cattle_volumes"
                                                            style="width:100%;height: 260px;">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div> 
                                        <div class="row mt-4">
                                            <div class="col-sm-12 col-md-12 col-lg-12">
                                                <div class="card border-0 card-shadow">
                                                    <div class="card-body">
                                                        <h4 class="chart-title">Goats</h4>
                                                        <div class="map_height" id="goats_volumes"
                                                            style="width:100%;height: 260px;">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-12 col-md-12 col-lg-12">
                                                <div class="card border-0 card-shadow">
                                                    <div class="card-body">
                                                        <h4 class="chart-title">Sheep</h4>
                                                        <div class="map_height" id="sheep_volumes"
                                                            style="width:100%;height: 260px;">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>   
                                         
                                    <!-- Livestock Volumes End upto here -->    
                                `;
                            $('.market_tab_3_view_details').html(HTML_GENERAL);
                            monthsimple_heat_map(response.fielddata_camel_milk_uai[0]['month_list'], response.fielddata_camel_milk_uai[0]['uai_list'], 'camel_mlilk_uai', response.fielddata_camel_milk_uai[0]['data'], 'Camel Milk UAI');
                            monthsimple_heat_map(response.fielddata_camel_milk_cluster[0]['month_list'], response.fielddata_camel_milk_cluster[0]['cluster_list'], 'camel_mlilk_cluster', response.fielddata_camel_milk_cluster[0]['data'], 'Camel Milk cluster');
                            monthsimple_heat_map(response.fielddata_cattle_milk_uai[0]['month_list'], response.fielddata_cattle_milk_uai[0]['uai_list'], 'cattle_milk_uai', response.fielddata_cattle_milk_uai[0]['data'], 'Cattle Milk UAI');
                            monthsimple_heat_map(response.fielddata_cattle_milk_cluster[0]['month_list'], response.fielddata_cattle_milk_cluster[0]['cluster_list'], 'cattle_milk_cluster', response.fielddata_cattle_milk_cluster[0]['data'], 'Cattle Milk cluster');
                            monthsimple_heat_map(response.fielddata_maize_grain_uai[0]['month_list'], response.fielddata_maize_grain_uai[0]['uai_list'], 'maize_grain_uai', response.fielddata_maize_grain_uai[0]['data'], 'Maize Grain UAI');
                            monthsimple_heat_map(response.fielddata_maize_grain_cluster[0]['month_list'], response.fielddata_maize_grain_cluster[0]['cluster_list'], 'maize_grain_cluster', response.fielddata_maize_grain_cluster[0]['data'], 'Maize Grain cluster');
                            monthsimple_heat_map(response.fielddata_sorghum_uai[0]['month_list'], response.fielddata_sorghum_uai[0]['uai_list'], 'sorghum_uai', response.fielddata_sorghum_uai[0]['data'], 'Sorghum UAI');
                            monthsimple_heat_map(response.fielddata_sorghum_cluster[0]['month_list'], response.fielddata_sorghum_cluster[0]['cluster_list'], 'sorghum_cluster', response.fielddata_sorghum_cluster[0]['data'], 'Sorghum cluster');
                            monthsimple_heat_map(response.fielddata_wheat_uai[0]['month_list'], response.fielddata_wheat_uai[0]['uai_list'], 'wheat_uai', response.fielddata_wheat_uai[0]['data'], 'Wheat UAI');
                            monthsimple_heat_map(response.fielddata_wheat_cluster[0]['month_list'], response.fielddata_wheat_cluster[0]['cluster_list'], 'wheat_cluster', response.fielddata_wheat_cluster[0]['data'], 'Wheat cluster');
                            monthsimple_heat_map(response.fielddata_sugar_uai[0]['month_list'], response.fielddata_sugar_uai[0]['uai_list'], 'sugar_uai', response.fielddata_sugar_uai[0]['data'], 'Sugar UAI');
                            monthsimple_heat_map(response.fielddata_sugar_cluster[0]['month_list'], response.fielddata_sugar_cluster[0]['cluster_list'], 'sugar_cluster', response.fielddata_sugar_cluster[0]['data'], 'Sugar cluster');
                            monthsimple_heat_map(response.fielddata_rice_uai[0]['month_list'], response.fielddata_rice_uai[0]['uai_list'], 'rice_uai', response.fielddata_rice_uai[0]['data'], 'Rice UAI');
                            monthsimple_heat_map(response.fielddata_rice_cluster[0]['month_list'], response.fielddata_rice_cluster[0]['cluster_list'], 'rice_cluster', response.fielddata_rice_cluster[0]['data'], 'Rice cluster');
                            monthsimple_grouped_barchart_1('animal_for_trade_1', response.fielddata_animal_for_trade_1, 'Number');
                            monthsimple_grouped_barchart_2('animal_for_trade_2', response.fielddata_animal_for_trade_2, 'Number');
                            // monthsimple_grouped_barchart_1('final_selling_price_1', response.fielddata_final_selling_price_1, 'Final Selling Price');
                            // monthsimple_grouped_barchart_2('final_selling_price_2', response.fielddata_final_selling_price_2, 'Final Selling Price');
                            // monthsimple_barchart('final_selling_price', response.fielddata_final_selling_price, 'in Local Currency');
                            monthsimple_grouped_livestock_barchart('livestock_animal_gender', response.fielddata_livestock_animal_gender, 'Number');
                            monthsimple_barchart('camel_selling_price', response.fielddata_camel_selling_price, 'in Local Currency');
                            monthsimple_barchart('cattle_selling_price', response.fielddata_cattle_selling_price, 'in Local Currency');
                            monthsimple_barchart('goats_selling_price', response.fielddata_goats_selling_price, 'in Local Currency');
                            monthsimple_barchart('sheep_selling_price', response.fielddata_sheep_selling_price, 'in Local Currency');
                            monthsimple_barchart('camel_volumes', response.fielddata_camel_volumes, 'Number');
                            monthsimple_barchart('cattle_volumes', response.fielddata_cattle_volumes, 'Number');
                            monthsimple_barchart('goats_volumes', response.fielddata_goats_volumes, 'Number');
                            monthsimple_barchart('sheep_volumes', response.fielddata_sheep_volumes, 'Number');
                            
                        }
                    }
                }).always(function(response) {
                // setTimeout(() => hideLoader(), 1000);
            });
        }

        function getSurveyDeatilsViewT4(){
            // alert("called");
            // showLoader();
            var country_id=$('select[name="country_id_4"]').val();
            var uai_id=$('select[name="uai_id_4"]').val();
            var sub_location_id=$('select[name="sub_location_id_4"]').val();
            var cluster_id=$('select[name="cluster_id_4"]').val();
            var start_date=$('input[name="start_date_4"]').val();
            var end_date=$('input[name="end_date_4"]').val();
            
            var query_data = {
                // filter_survey: filter,
                country_id : country_id,
                // market_id : market_id,
                uai_id : uai_id,
                sub_location_id : sub_location_id,
                cluster_id : cluster_id,
                // start_date : formatDate(start_date),
                // end_date : formatDate(end_date)
                start_date : start_date,
                end_date : end_date

            };
                $('.market_tab_4_view_details').html('<h4 class="text-center loading">Please Wait. Getting Data</h4>');
                $.ajax({
                    url : "<?php echo base_url(); ?>dashboard/get_market_tab_4/",
                    data : query_data,
                    type : "POST",
                    dataType : "JSON",
                    error:function(){	            	
                        // $('#beneficiary_data').find('.loading').remove();
                        // $.toast({
                        // 	heading: 'Network Error!',
                        // 	text: 'Could not establish connection to server. Please refresh the page and try again.',
                        // 	icon: 'error'
                        // });
                    },
                    success:function(response){
                        if(response.status == 1){
                            var HTML_GENERAL = `
                                    <!-- Livestock Prices & Quality start from here -->
                                    <!-- <h4>Livestock Prices & Quality </h4></br> -->
                                    <h4>Transect forage conditions</h4></br>
                                        <div class="row">
                                            <div class="col-sm-12 col-md-12 col-lg-12">
                                                <div class="card border-0  card-shadow">
                                                    <div class="card-body">
                                                        <div class="chart-title mb-3">Plotting of pasture current condition of forage availability </div>
                                                        <p style="font-size:16px;"><b>Color code :</b></p>
                                                        <table style="text-align:center;">
                                                            <tr>
                                                                <td width="20%" height="40px" style="background-color: brown;color:white;line-height: 40px;font-size:22px;text-align:center" class="">Very scarce</td>
                                                                <td width="20%" height="40px" style="background-color: orange;color:black;line-height: 40px;font-size:22px;text-align:center" class="">Somewhat scarce</td>
                                                                <td width="20%" height="40px" style="background-color: yellow;color:black;line-height: 40px;font-size:22px;text-align:center" class="">Available</td>
                                                                <td width="20%" height="40px" style="background-color: blue;color:white;line-height: 40px;font-size:22px;text-align:center" class="">Somewhat plenty</td>
                                                                <td width="20%" height="40px" style="background-color: green;color:white;line-height: 40px;font-size:22px;text-align:center" class="">Very plenty</td>
                                                            </tr>
                                                        </table>
                                                        <div id="new_map_kml"></div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-12 col-md-6 col-lg-6">
                                                <div class="card border-0 card-shadow">
                                                    <div class="card-body">
                                                        <h4 class="chart-title">Animal types are currently grazing</h4>
                                                        <div class="" id="animal_types_are_currently_grazing"
                                                            style="width: 100%;height: 400px;"></div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-12 col-md-6 col-lg-6">
                                                <div class="card border-0 card-shadow">
                                                    <div class="card-body">
                                                        <h4 class="chart-title">Protected grazing area</h4>
                                                        <div class="" id="protected_grazing_area"
                                                            style="width: 100%;height: 400px;"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    <!-- Livestock Volumes End upto here -->          
                                `;
                            $('.market_tab_4_view_details').html(HTML_GENERAL);
                            monthsimple_barchart('animal_types_are_currently_grazing', response.fielddata_animal_types_are_currently_grazing, 'Number');
                            monthsimple_barchart('protected_grazing_area', response.fielddata_protected_grazing_area, 'Number');
                            // monthsimple_barchart('sheep_volumes', response.fielddata_sheep_volumes, 'Sheep volumes');
                            monthsimple_map("new_map_kml", response.fielddata_rangeland_map_kml, 'Plotting of pasture current condition');
                        }
                    }
                }).always(function(response) {
                // setTimeout(() => hideLoader(), 1000);
            });
        }

        function monthsimple_piechart(divid, data, yaxis_units){
            Highcharts.chart(divid, {
                chart: {
                    plotBackgroundColor: null,
                    plotBorderWidth: null,
                    plotShadow: false,
                    type: 'pie'
                },
                title: {
                    text: '',
                    align: 'left'
                },
                tooltip: {
                    pointFormat: '{series.name}: <b>{point.y}</b>'
                },
                accessibility: {
                    point: {
                        valueSuffix: '%'
                    }
                },
                exporting: {
                    enabled: false
                },
                credits: {
                    enabled: false
                },
                plotOptions: {
                    pie: {
                        cursor: 'pointer',
                        dataLabels: {
                            enabled: true,
                            format: '<b>{point.name} : </b> <b>{point.percentage:.1f}%</b>'
                        },
                        showInLegend: false
                    }
                },
                // plotOptions: {
                //     series: {
                //         borderWidth: 0,
                //         dataLabels: {
                //             enabled: true,
                //             color: '#000',
                //             format: '{point.y:.1f}', 
                //             y: -5, 
                        
                //         }
                //     }
                // },
                // legend: {
                //     enabled: true,
                //     // layout: 'vertical',
                //     // align: 'right',
                //     // width: 200,
                //     // verticalAlign: 'middle',
                //     // useHTML: true,
                //     // labelFormatter: function() {
                //     //     return '<div style="text-align: left; width:130px;float:left;">' + this.name + '</div><div style="width:40px; float:left;text-align:right;">' + this.y + '%</div>';
                //     // }
                //     labelFormatter: function() {
                //         return this.name + " (" + (this.y/total*100).toFixed(2) + "%)";
                //     }
                // },
                series: [{
                    name: yaxis_units,
                    data: data
                    // data: [{
                    //     name: 'Male',
                    //     color: '#6FA1E7',
                    //     y: 30,
                    // }, {
                    //     name: 'Female',
                    //     color: '#FFB6BA',
                    //     y: 20,
                    // }]
                }]
            });
        }

        function monthsimple_barchart(divid, data, yaxis_units){
            // Assuming your graph data is stored in an array called 'data'
            // Check if all values in the array are zeros
            const isAllZeros = data.every(code => code.y === 0);

            if (isAllZeros) {
                // If all values are zeros, display "No data" message
                Highcharts.chart(divid, {
                    title: {
                    text: 'Data not available',
                    align: 'center',
                    verticalAlign: 'middle'
                    },
                    credits: {
                        enabled: false
                    },
                    series: []
                });
            } else {
                // Create your Highcharts chart with the actual data
                Highcharts.chart(divid, {
                    chart: {
                        type: 'column'
                    },
                    title: {
                        align: 'left',
                        text: ''
                    },
                    subtitle: {
                        align: 'left',
                        text: ''
                    },
                    accessibility: {
                        announceNewData: {
                            enabled: true
                        }
                    },
                    xAxis: {
                        type: 'category'
                    },
                    yAxis: {
                        title: {
                            text: yaxis_units
                        }

                    },
                    // legend: {
                    //     enabled: true
                    // },
                    exporting: {
                        enabled: true
                    },
                    credits: {
                        enabled: false
                    },
                    plotOptions: {
                        series: {
                            borderWidth: 0,
                            showInLegend: false,
                            dataLabels: {
                                enabled: true,
                                color: '#000',
                                format: '{point.y}', 
                                y: -5, 
                            
                            }
                        }
                    },
                    // plotOptions: {
                    //     column: {
                    //         stacking: 'normal',
                    //         pointPadding: 0,
                    //         groupPadding: 0,
                    //         dataLabels: {
                    //             enabled: false
                    //         }
                    //     }
                    // },
                    // point: {
                    //     events: {
                    //         mouseOut: function () {
                    //             this.series.chart.pointer.prevKDPoint = null;
                    //         }
                    //     }
                    // },
                    tooltip: {
                        headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
                        pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y}</b><br/>'
                    },
                    series: [
                        { 
                            name: yaxis_units,
                            colorByPoint: true,
                            // data: data
                            // data: data.filter(b => b.y != 0).map(a=>a.y)
                            data: data.filter(d => d.y != 0)
                            
                        }
                    ],
                });
            }
        }

        function monthsimple_barchart_categories(divid, data, yaxis_units, categories){
            // Assuming your graph data is stored in an array called 'data'
            // Check if all values in the array are zeros
            const isAllZeros = data.every(code => code.y === 0);

            if (isAllZeros) {
                // If all values are zeros, display "No data" message
                Highcharts.chart(divid, {
                    title: {
                    text: 'Data not available',
                    align: 'center',
                    verticalAlign: 'middle'
                    },
                    credits: {
                        enabled: false
                    },
                    series: []
                });
            } else {
                // Create your Highcharts chart with the actual data
                Highcharts.chart(divid, {
                    chart: {
                        type: 'column'
                    },
                    title: {
                        align: 'left',
                        text: ''
                    },
                    subtitle: {
                        align: 'left',
                        text: ''
                    },
                    accessibility: {
                        announceNewData: {
                            enabled: true
                        }
                    },
                    xAxis: {
                        type: 'category'
                    },
                    yAxis: {
                        title: {
                            text: yaxis_units
                        }

                    },
                    // legend: {
                    //     enabled: true
                    // },
                    exporting: {
                        enabled: true
                    },
                    credits: {
                        enabled: false
                    },
                    plotOptions: {
                        series: {
                            borderWidth: 0,
                            showInLegend: false,
                            dataLabels: {
                                enabled: true,
                                color: '#000',
                                format: '{point.y}', 
                                y: -5, 
                            
                            }
                        }
                    },
                    // plotOptions: {
                    //     column: {
                    //         stacking: 'normal',
                    //         pointPadding: 0,
                    //         groupPadding: 0,
                    //         dataLabels: {
                    //             enabled: false
                    //         }
                    //     }
                    // },
                    // point: {
                    //     events: {
                    //         mouseOut: function () {
                    //             this.series.chart.pointer.prevKDPoint = null;
                    //         }
                    //     }
                    // },
                    tooltip: {
                        headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
                        pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y}</b><br/>'
                    },
                    series: [
                        { 
                            name: yaxis_units,
                            colorByPoint: true,
                            // data: data
                            // data: data.filter(b => b.y != 0).map(a=>a.y)
                            data: data.filter(d => d.y != 0)
                            
                        }
                    ],
                });
            }
        }

        function simple_line_graph(divid, data, yaxis_units){
            Highcharts.chart(divid, {

                chart: {
                    type: 'line'
                },
                title: {
                    text: null
                },
                
                credits: {
                    enabled: false
                },
                // title: {
                //     text: 'Monthly Average Temperature'
                // },
                
                xAxis: {
                    // categories: ['Camel', 'Cattle', 'Goat', 'Sheep', 'None']
                    categories: ['Camel', 'Goat', 'Sheep', 'Cattle']
                },
                yAxis: {
                    title: {
                        text: yaxis_units
                    }
                },
                plotOptions: {
                    line: {
                        dataLabels: {
                            enabled: true
                        },
                        enableMouseTracking: true
                    }
                },
                series: [{
                    name: yaxis_units,
                    data : data
                    // data: [16.0, 18.2, 23.1, 27.9, 32.2, 36.4, 39.8, 38.4, 35.5, 29.2,
                    //     22.0, 17.8]
                }]

            });
        }
        function monthsimple_map(divid, data, yaxis_units){
            
            
            // Creating map options
            var mapOptions = {
                center: [16.506174, 80.648015],
                // center: [15.831629999999999, 80.34891333333333],
                zoom: 7
            }
            // Creating a map object
            var map = new L.map('new_map_kml', mapOptions);
            
            // Creating a Layer object
            var layer = new L.TileLayer('http://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png');
            
            // Adding layer to the map
            map.addLayer(layer);

            // Define the polygon data as an array of objects, where each object contains the latitude and longitude coordinates and a color value
            // var polygonData = [
            // {latlng: [[51.509865, -0.118092], [51.503054, -0.113215], [51.498383, -0.108409]], color: 'red'},
            // {latlng: [[51.496326, -0.100696], [51.499506, -0.090579], [51.506752, -0.087615]], color: 'green'},
            // {latlng: [[51.512161, -0.091058], [51.514597, -0.102563], [51.510745, -0.112013]], color: 'blue'}
            // ];
            var polygonData = data;
            

            // Create an array to hold the polygons
            var polygons = [];

            // Loop through the polygon data and create a polygon for each set of vertices
            for (var i = 0; i < polygonData.length; i++) {
                var latlng = polygonData[i].latlng;
                var color = polygonData[i].color;
                var popupdata = polygonData[i].popupdata;
                var popupdatavalue = popupdata[0]['name']+" ";
                var polygon = L.polygon(latlng, {color: color, fillOpacity: 0.5});
                // Define the HTML content for the popup
                var popupContent = '<h5>Pasture Details</h5><br/><div class="mb-3" style="font-size: 18px;">Pasture Name : ' + (popupdata[0]['name'])+'<br/>Pasture Type : ' + (popupdata[0]['type'])+'<br/>Animal Type : ' + (popupdata[0]['animal_type'])+'<br/>Forage Condition Type : ' + (popupdata[0]['forage_type'])+'<br/>Contributor Name : ' + (popupdata[0]['contributor_name'])+'<br/></div>';
                polygon.bindPopup(popupContent);
                // polygon.bindPopup('Pasturen Name : ' + (popupdata[0]['name']));
                // polygon.bindPopup('contributor Name : ' + (popupdata[0]['contributor_name']));
                polygons.push(polygon);
            }

            // Create a layer group to hold the polygons
            var polygonGroup = L.layerGroup(polygons);

            // Add the polygon group to a Leaflet map
            // var map = L.map('new_map_kml').setView([51.505, -0.09], 13);
            polygonGroup.addTo(map);
        }

        function monthsimple_linechart(divid, data, yaxis_units){
            Highcharts.chart(divid, {
                chart: {
                    type: 'spline',
                },
                title: {
                    text: ''
                },
                xAxis: {
                    categories: ['Jan', 'Feb', 'Mar', 'April', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec']
                },
                yAxis: {
                    min: 0,
                    title: {
                        text: ''
                    }
                },
                tooltip: {
                    pointFormat: '<span style="color:{series.color}">{series.name}</span>: <b>{point.y}</b> ({point.percentage:.0f}%)<br/>',
                    shared: true
                },
                plotOptions: {
                    series: {
                        marker: {
                            enabled: true,
                            radius: 2.5,
                            symbol: 'circle'
                        },
                        labels: {
                            enabled: false,
                            //radius: 2.5
                        }
                    }
                },
                legend: {
                    reversed: true,
                },
                exporting: {
                    enabled: false
                },
                credits: {
                    enabled: false
                },
                series: data
                // series: [{
                //     name: 'Sheep',
                //     color: '#F7BA1E',
                //     data: [4, 4, 2, 4, 4, 3, 4, 5, 6, 4, 5, 7]
                // }, {
                //     name: 'Goats',
                //     color: '#14C9C9',
                //     data: [1, 2, 2, 1, 2, 3, 2, 4, 2, 3, 4, 5]
                // }, {
                //     name: 'Cattle',
                //     color: '#FFB6BA',
                //     data: [5, 4, 3, 2, 3, 3, 4, 5, 4, 3, 4, 5]
                // }, {
                //     name: 'Camels',
                //     color: '#165DFF',
                //     data: [4, 4, 2, 4, 4, 5, 4, 6, 5, 7, 5, 3]
                // },]
            });
        }

        function stacked_bar(divid, data, categories, yaxis_units){
            Highcharts.chart(divid, {
                chart: {
                    type: 'column'
                },
                
                xAxis: {
                    // categories: ['Arsenal', 'Chelsea', 'Liverpool', 'Manchester United']
                    categories: categories
                },
                yAxis: {
                    min: 0,
                    title: {
                        text: 'Number'
                    },
                    stackLabels: {
                        enabled: true
                    }
                },
                
                tooltip: {
                    headerFormat: '<b>{point.x}</b><br/>',
                    pointFormat: '{series.name}: {point.y}<br/>Total: {point.stackTotal}'
                },
                plotOptions: {
                    column: {
                        stacking: 'normal',
                        dataLabels: {
                            enabled: true
                        }
                    }
                },
                series: data
                // series: [{
                //     name: 'BPL',
                //     color: 'red',
                //     data: [3, 5, 1, 13]
                // }, {
                //     name: 'FA Cup',
                //     color: 'blue',
                //     data: [14, 8, 8, 12]
                // }, {
                //     name: 'CL',
                //     color: 'green',
                //     data: [0, 2, 6, 3]
                // }]
            });

        }
        function monthsimple_grouped_barchart(divid, data, yaxis_units){
            var ftype= '';
            if(divid =='average_liters_milk_per_day' ||divid =='average_Selling_Price' ){
                ftype= '{point.y:.1f}';
            }else{
                ftype= '{point.y}';
            }
             // Assuming your graph data is stored in an array called 'data'
            // Check if all values in the array are zeros
            const isAllZeros = data.every(code => code.data.every(value => value === 0));

            if (isAllZeros) {
                // If all values are zeros, display "No data" message
                Highcharts.chart(divid, {
                    title: {
                    text: 'Data not available',
                    align: 'center',
                    verticalAlign: 'middle'
                    },
                    credits: {
                        enabled: false
                    },
                    series: []
                });
            } else {
                // Create your Highcharts chart with the actual data
                Highcharts.chart(divid, {
                    chart: {
                        type: 'column'
                    },
                    title: {
                        text: ''
                    },
                    subtitle: {
                        text: ''
                    },
                    credits: {
                        enabled: false
                    },
                    xAxis: {
                        categories: [
                            'Camel',
                            'Goat',
                            'Sheep',               
                            'Cattle',
                            // if(divid=="")   {
                            //    'none', 
                            // }  
                    ],
                        crosshair: true
                    },
                    yAxis: {
                        min: 0,
                        title: {
                            text: yaxis_units
                        }
                    },
                    tooltip: {
                        headerFormat: '<span style="font-size:15px">{point.key}</span><table>',
                        pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                            '<td style="padding:0"><b>{point.y}</b></td></tr>',
                        footerFormat: '</table>',
                        shared: true,
                        useHTML: true
                    },
                    plotOptions: {
                        series: {
                            borderWidth: 0,
                            dataLabels: {
                            enabled: true,
                            format: '{point.y}'
                            }
                        }
                    },
                    series: data
                    // series: [{
                    //     name: 'Deaths occurred in your mature herded',
                    //     color: '#165DFF',
                    //     data: [49.9, 71.5, 106.4, 83.6]

                    // }, {
                    //     name: 'Deaths occurred in your young herded',
                    //     color: '#F7BA1E',
                    //     data: [83.6, 78.8, 98.5, 49.9]

                    // }]
                });
            }
        }
        function monthsimple_grouped_livestock_barchart(divid, data, yaxis_units){
            var ftype= '';
            if(divid =='average_liters_milk_per_day' ||divid =='average_Selling_Price' ){
                ftype= '{point.y:.1f}';
            }else{
                ftype= '{point.y}';
            }
             // Assuming your graph data is stored in an array called 'data'
            // Check if all values in the array are zeros
            const isAllZeros = data.every(code => code.data.every(value => value === 0));

            if (isAllZeros) {
                // If all values are zeros, display "No data" message
                Highcharts.chart(divid, {
                    title: {
                    text: 'Data not available',
                    align: 'center',
                    verticalAlign: 'middle'
                    },
                    credits: {
                        enabled: false
                    },
                    series: []
                });
            } else {
                // Create your Highcharts chart with the actual data
                Highcharts.chart(divid, {
                    chart: {
                        type: 'column'
                    },
                    title: {
                        text: ''
                    },
                    subtitle: {
                        text: ''
                    },
                    credits: {
                        enabled: false
                    },
                    xAxis: {
                        categories: [
                            'Female',
                            'Male Castrated',
                            'Male Uncastrated', 
                            // if(divid=="")   {
                            //    'none', 
                            // }  
                    ],
                        crosshair: true
                    },
                    yAxis: {
                        min: 0,
                        title: {
                            text: yaxis_units
                        }
                    },
                    tooltip: {
                        headerFormat: '<span style="font-size:15px">{point.key}</span><table>',
                        pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                            '<td style="padding:0"><b>{point.y}</b></td></tr>',
                        footerFormat: '</table>',
                        shared: true,
                        useHTML: true
                    },
                    plotOptions: {
                        series: {
                            borderWidth: 0,
                            dataLabels: {
                            enabled: true,
                            format: '{point.y}'
                            }
                        }
                    },
                    series: data
                    // series: [{
                    //     name: 'Deaths occurred in your mature herded',
                    //     color: '#165DFF',
                    //     data: [49.9, 71.5, 106.4, 83.6]

                    // }, {
                    //     name: 'Deaths occurred in your young herded',
                    //     color: '#F7BA1E',
                    //     data: [83.6, 78.8, 98.5, 49.9]

                    // }]
                });
            }
        }
        function monthsimple_grouped_yesno_barchart(divid, data, yaxis_units){
            var ftype= '';
            if(divid =='average_liters_milk_per_day' ||divid =='average_Selling_Price' ){
                ftype= '{point.y:.1f}';
            }else{
                ftype= '{point.y}';
            }
            Highcharts.chart(divid, {
                chart: {
                    type: 'column'
                },
                title: {
                    text: ''
                },
                subtitle: {
                    text: ''
                },
                credits: {
                    enabled: false
                },
                xAxis: {
                    categories: [
                        // 'Yes',
                        // 'No',
                        'Age 0-5 (children)',
                        'Age 5-17',
                        'Age 18-65',
                        
                        // if(divid=="")   {
                        //    'none', 
                        // }  
                  ],
                    crosshair: true
                },
                yAxis: {
                    min: 0,
                    title: {
                        text: yaxis_units
                    }
                },
                tooltip: {
                    headerFormat: '<span style="font-size:15px">{point.key}</span><table>',
                    pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                        '<td style="padding:0"><b>{point.y}</b></td></tr>',
                    footerFormat: '</table>',
                    shared: true,
                    useHTML: true
                },
                plotOptions: {
                    series: {
                        borderWidth: 0,
                        dataLabels: {
                        enabled: true,
                        format: '{point.y}'
                        }
                    }
                },
                series: data
                // series: [{
                //     name: 'Deaths occurred in your mature herded',
                //     color: '#165DFF',
                //     data: [49.9, 71.5, 106.4, 83.6]

                // }, {
                //     name: 'Deaths occurred in your young herded',
                //     color: '#F7BA1E',
                //     data: [83.6, 78.8, 98.5, 49.9]

                // }]
            });
        }
        function monthsimple_grouped_barchart_1(divid, data, yaxis_units){
            Highcharts.chart(divid, {
                chart: {
                    type: 'column'
                },
                title: {
                    text: ''
                },
                subtitle: {
                    text: ''
                },
                credits: {
                    enabled: false
                },
                xAxis: {
                    categories: [
                        'Camel',              
                        'Cattle',
                        // if(divid=="")   {
                        //    'none', 
                        // }  
                  ],
                    crosshair: true
                },
                yAxis: {
                    min: 0,
                    title: {
                        text: yaxis_units
                    }
                },
                // tooltip: {
                //     headerFormat: '<span style="font-size:15px">{point.key}</span><table>',
                //     pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                //         '<td style="padding:0"><b>{point.y}</b></td></tr>',
                //     footerFormat: '</table>',
                //     shared: true,
                //     useHTML: true
                // },
                plotOptions: {
                    series: {
                        borderWidth: 0,
                        dataLabels: {
                        enabled: true,
                        format: '{point.y}'
                        }
                    }
                },
                series: data
                // series: [{
                //     name: 'Deaths occurred in your mature herded',
                //     color: '#165DFF',
                //     data: [49.9, 71.5, 106.4, 83.6]

                // }, {
                //     name: 'Deaths occurred in your young herded',
                //     color: '#F7BA1E',
                //     data: [83.6, 78.8, 98.5, 49.9]

                // }]
            });
        }
        function monthsimple_grouped_barchart_2(divid, data, yaxis_units){
            Highcharts.chart(divid, {
                chart: {
                    type: 'column'
                },
                title: {
                    text: ''
                },
                subtitle: {
                    text: ''
                },
                credits: {
                    enabled: false
                },
                xAxis: {
                    categories: [
                        'Goat',
                        'Sheep',
                        // if(divid=="")   {
                        //    'none', 
                        // }  
                  ],
                    crosshair: true
                },
                yAxis: {
                    min: 0,
                    title: {
                        text: yaxis_units
                    }
                },
                // tooltip: {
                //     headerFormat: '<span style="font-size:15px">{point.key}</span><table>',
                //     pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                //         '<td style="padding:0"><b>{point.y}</b></td></tr>',
                //     footerFormat: '</table>',
                //     shared: true,
                //     useHTML: true
                // },
                plotOptions: {
                    series: {
                        borderWidth: 0,
                        dataLabels: {
                        enabled: true,
                        format: '{point.y}'
                        }
                    }
                },
                series: data
                // series: [{
                //     name: 'Deaths occurred in your mature herded',
                //     color: '#165DFF',
                //     data: [49.9, 71.5, 106.4, 83.6]

                // }, {
                //     name: 'Deaths occurred in your young herded',
                //     color: '#F7BA1E',
                //     data: [83.6, 78.8, 98.5, 49.9]

                // }]
            });
        }
        function monthsimple_grouped_barchart_11(divid, data, yaxis_units){
            Highcharts.chart(divid, {
                chart: {
                    type: 'column'
                },
                title: {
                    text: ''
                },
                subtitle: {
                    text: ''
                },
                credits: {
                    enabled: false
                },
                xAxis: {
                    categories: [
                        'Camel',              
                        'Goat',
                        'Sheep',
                        // if(divid=="")   {
                        //    'none', 
                        // }  
                  ],
                    crosshair: true
                },
                yAxis: {
                    min: 0,
                    title: {
                        text: yaxis_units
                    }
                },
                // tooltip: {
                //     headerFormat: '<span style="font-size:15px">{point.key}</span><table>',
                //     pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                //         '<td style="padding:0"><b>{point.y}</b></td></tr>',
                //     footerFormat: '</table>',
                //     shared: true,
                //     useHTML: true
                // },
                plotOptions: {
                    series: {
                        borderWidth: 0,
                        dataLabels: {
                        enabled: true,
                        format: '{point.y}'
                        }
                    }
                },
                series: data
                // series: [{
                //     name: 'Deaths occurred in your mature herded',
                //     color: '#165DFF',
                //     data: [49.9, 71.5, 106.4, 83.6]

                // }, {
                //     name: 'Deaths occurred in your young herded',
                //     color: '#F7BA1E',
                //     data: [83.6, 78.8, 98.5, 49.9]

                // }]
            });
        }
        function monthsimple_grouped_barchart_22(divid, data, yaxis_units){
            Highcharts.chart(divid, {
                chart: {
                    type: 'column'
                },
                title: {
                    text: ''
                },
                subtitle: {
                    text: ''
                },
                credits: {
                    enabled: false
                },
                xAxis: {
                    categories: [
                        'Cattle',
                        // if(divid=="")   {
                        //    'none', 
                        // }  
                  ],
                    crosshair: true
                },
                yAxis: {
                    min: 0,
                    title: {
                        text: yaxis_units
                    }
                },
                // tooltip: {
                //     headerFormat: '<span style="font-size:15px">{point.key}</span><table>',
                //     pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                //         '<td style="padding:0"><b>{point.y}</b></td></tr>',
                //     footerFormat: '</table>',
                //     shared: true,
                //     useHTML: true
                // },
                plotOptions: {
                    series: {
                        borderWidth: 0,
                        dataLabels: {
                        enabled: true,
                        format: '{point.y}'
                        }
                    }
                },
                series: data
                // series: [{
                //     name: 'Deaths occurred in your mature herded',
                //     color: '#165DFF',
                //     data: [49.9, 71.5, 106.4, 83.6]

                // }, {
                //     name: 'Deaths occurred in your young herded',
                //     color: '#F7BA1E',
                //     data: [83.6, 78.8, 98.5, 49.9]

                // }]
            });
        }
        function monthsimple_bar_linechart(divid, bardata, linedata, yaxis_units){
            Highcharts.chart('average_liters_milk_per_day', {
                title: {
                    text: '',
                },
                xAxis: {
                    categories: ['Camel', 'Cattle', 'Goat', 'Sheep']
                },
                yAxis: {
                    title: {
                        text: ''
                    }
                },
                exporting: {
                    enabled: false
                },
                credits: {
                    enabled: false
                },
                tooltip: {
                    valueSuffix: ''
                },
                plotOptions: {
                    series: {
                        borderWidth: 0,
                        dataLabels: {
                            enabled: true,
                            color: '#000',
                            format: '{point.y}', 
                            y: -5, 
                        
                        }
                    }
                },
                series: [{
                    type: 'column',
                    color: '#165DFF',
                    name: 'No.of litres of milk do you sell per day',
                    // data: [59, 83, 65, 228]
                    data: bardata
                }, {
                    type: 'spline',
                    color: '#14C9C9',
                    name: ' Current selling price of ONE litre of the milk sold',
                    // data: [47, 83.33, 70.66, 239.33],
                    data: linedata,
                },]
            });
        }
        function monthsimple_heat_map(xcategories, ycategories, divid, data, yaxis_units){
            var item_value='';
            if(divid == 'camel_mlilk_uai' || divid == 'camel_mlilk_cluster' || divid == 'cattle_milk_uai' || divid == 'cattle_milk_cluster' ) {
                item_value="litre Milk";
            }else {
                item_value="Kilogram";
            }
            Highcharts.chart(divid, {

                chart: {
                    type: 'heatmap',
                    // marginTop: 40,
                    // marginBottom: 80,
                    // plotBorderWidth: 1
                },


                title: {
                    text: ''
                },

                xAxis: {
                    // categories: ['Mar 21', 'Apr 21', 'May 21', 'Jun 21', 'Jul 21', 'Aug 21', 'Sep 21', 'Oct 21', 'Nv 21', 'Dec 21']
                    // categories: ['Mar 21', 'Apr 21', 'May 21', 'Jun 21', 'Jul 21', 'Aug 21', 'Sep 21']
                    categories: xcategories
                },
                exporting: {
                    enabled: false
                },
                credits: {
                    enabled: false
                },
                yAxis: {
                    labels: {
                        overflow: 'justify',
                        align: 'center',
                    },
                    // categories: ['Kargi', 'Korr', 'Merille', 'Ol turot','five','six','seven','eight'],
                    categories: ycategories,
                    title: null,
                    reversed: true
                },

                accessibility: {
                    point: {
                        descriptionFormatter: function (point) {
                            var ix = point.index + 1,
                                xName = getPointCategoryName(point, 'x'),
                                yName = getPointCategoryName(point, 'y'),
                                val = point.value;
                            return ix + '. ' + xName + ' sales ' + yName + ', ' + val + '.';
                        }
                    }
                },

                // colorAxis: {
                //     min: 0,
                //     minColor: '#FFFFFF',
                //     maxColor: Highcharts.getOptions().colors[0]
                // },
                colorAxis: {
                    stops: [
                        [0, '#C8E76F'], //  for values <= 10
                        [0.5, '#F7BA1E'], // green for values between 10 and 20
                        [1, '#5978A3'] // red for values > 20
                    ]
                },
                    
                tooltip: {
                    formatter: function () {
                        return '<b>' + getPointCategoryName(this.point, 'x') + '</b> <br><b>' +
                            this.point.value + '</b> is price of one '+ item_value +' in this cluster<br><b>' + getPointCategoryName(this.point, 'y') + '</b>';
                    }
                },
                

                series: [{
                    // name: 'Camel Milk',
                    name: yaxis_units,
                    borderWidth: 0,
                    // data: [[0, 0, 10], [0, 1, 19], [0, 2, 8], [0, 3, 24], [1, 0, 92], [1, 1, 58], [1, 2, 78], [1, 3, 117], [2, 0, 35], [2, 1, 15], [2, 2, 123], [2, 3, 64], [3, 0, 72], [3, 1, 132], [3, 2, 114], [3, 3, 19], [4, 0, 38], [4, 1, 5], [4, 2, 8], [4, 3, 117], [5, 0, 88], [5, 1, 32], [5, 2, 12], [5, 3, 6], [6, 0, 13], [6, 1, 44], [6, 2, 88], [6, 3, 98], [7, 0, 31], [7, 1, 1], [7, 2, 82], [7, 3, 32], [8, 0, 85], [8, 1, 97], [8, 2, 123], [8, 3, 64], [9, 0, 47], [9, 1, 114], [9, 2, 31], [9, 3, 48]],
                    data: data,
                    dataLabels: {
                        enabled: true,
                        color: '#000000'
                    }
                }],

                responsive: {
                    rules: [{
                        condition: {
                            maxWidth: 500
                        },
                        chartOptions: {
                            yAxis: {
                                labels: {
                                    formatter: function () {
                                        return this.value.charAt(0);
                                    }
                                }
                            }
                        }
                    }]
                },
                
            });
        }
        function monthsimple_heat_map1(xcategories, ycategories, divid, data, yaxis_units){
            var item_value='';
            if(divid == 'camel_mlilk_uai' || divid == 'camel_mlilk_cluster' || divid == 'cattle_milk_uai' || divid == 'cattle_milk_cluster' ) {
                item_value="litre Milk";
            }else {
                item_value="Kilogram";
            }
            Highcharts.chart(divid, {

                chart: {
                    type: 'heatmap',
                    // marginTop: 40,
                    // marginBottom: 80,
                    // plotBorderWidth: 1
                },


                title: {
                    text: ''
                },

                xAxis: {
                    // categories: ['Mar 21', 'Apr 21', 'May 21', 'Jun 21', 'Jul 21', 'Aug 21', 'Sep 21', 'Oct 21', 'Nv 21', 'Dec 21']
                    // categories: ['Mar 21', 'Apr 21', 'May 21', 'Jun 21', 'Jul 21', 'Aug 21', 'Sep 21']
                    categories: xcategories
                },
                exporting: {
                    enabled: false
                },
                credits: {
                    enabled: false
                },
                yAxis: {
                    // categories: ['Kargi', 'Korr', 'Merille', 'Ol turot','five','six','seven','eight'],
                    categories: ycategories,
                    title: null,
                    reversed: true
                },

                accessibility: {
                    point: {
                        descriptionFormatter: function (point) {
                            var ix = point.index + 1,
                                xName = getPointCategoryName(point, 'x'),
                                yName = getPointCategoryName(point, 'y'),
                                val = point.value;
                            return ix + '. ' + xName + ' sales ' + yName + ', ' + val + '.';
                        }
                    }
                },

                // colorAxis: {
                //     min: 0,
                //     minColor: '#FFFFFF',
                //     maxColor: Highcharts.getOptions().colors[0]
                // },
                colorAxis: {
                    stops: [
                        [0, '#C8E76F'], //  for values <= 10
                        [0.5, '#F7BA1E'], // green for values between 10 and 20
                        [1, '#5978A3'] // red for values > 20
                    ]
                },
                    
                tooltip: {
                    formatter: function () {
                        return null;
                    }
                },
                

                series: [{
                    // name: 'Camel Milk',
                    name: yaxis_units,
                    borderWidth: 0,
                    // data: [[0, 0, 10], [0, 1, 19], [0, 2, 8], [0, 3, 24], [1, 0, 92], [1, 1, 58], [1, 2, 78], [1, 3, 117], [2, 0, 35], [2, 1, 15], [2, 2, 123], [2, 3, 64], [3, 0, 72], [3, 1, 132], [3, 2, 114], [3, 3, 19], [4, 0, 38], [4, 1, 5], [4, 2, 8], [4, 3, 117], [5, 0, 88], [5, 1, 32], [5, 2, 12], [5, 3, 6], [6, 0, 13], [6, 1, 44], [6, 2, 88], [6, 3, 98], [7, 0, 31], [7, 1, 1], [7, 2, 82], [7, 3, 32], [8, 0, 85], [8, 1, 97], [8, 2, 123], [8, 3, 64], [9, 0, 47], [9, 1, 114], [9, 2, 31], [9, 3, 48]],
                    data: data,
                    dataLabels: {
                        enabled: true,
                        color: '#000000'
                    }
                }],

                responsive: {
                    rules: [{
                        condition: {
                            maxWidth: 500
                        },
                        chartOptions: {
                            yAxis: {
                                labels: {
                                    formatter: function () {
                                        return this.value.charAt(0);
                                    }
                                }
                            }
                        }
                    }]
                },
                
            });
        }
        function monthstacked_grouped_barchart(divid, xcategories, data1, data2, yaxis_units){
            // Highcharts.chart('sample_container', {
            Highcharts.chart(divid, {
                chart: {
                    type: 'column'
                },
                title: {
                    text: ''
                },
                xAxis: {
                    // categories: ['Jan', 'Feb', 'Mar']
                    categories: xcategories
                },
                yAxis: {
                    min: 0,
                    title: {
                        text: ''
                    },
                    stackLabels: {
                        enabled: true,
                        format: '{total}',
                        style: {
                            fontWeight: 'bold',
                            // color: (Highcharts.theme && Highcharts.theme.textColor) || 'gray'
                        }
                    }
                },
                legend: {
                    align: 'right',
                    x: -30,
                    verticalAlign: 'top',
                    y: 25,
                enabled:false,
                    floating: true,
                    backgroundColor: (Highcharts.theme && Highcharts.theme.background2) || 'white',
                    borderColor: '#CCC',
                    borderWidth: 1,
                    shadow: false
                },
            
                tooltip: {
                    formatter: function () {
                        return '<b>' + this.x + '</b><br/>' +
                            this.series.name + ': ' + this.y + '<br/>' +
                            'Total People surveyed : ' + this.point.stackTotal + '';
                    }
                },
                stackLabels: {
                enabled: false,
                },
                plotOptions: {
                    column: {
                    stacking: 'normal',
                    dataLabels: {
                        enabled: true,
                        format: '{point.percentage:.1f} %'
                    }
                    }
                },
                series: [{
                    name: 'People who ate <5 Food groups',
                color: '#F7BA1E',
                    // data: [200.3, 30, 0]
                    data: data1
                }, {
                    name: 'People who ate >=5 Food groups',
                color: '#6A9F58',
                    // data: [154.7, 70, 85]
                    data: data2
                }]
            });

        }
        
        /*  Sagar wrote code for loading dashboards upto here*/
</script>


    <script>
    
        $('body').on('click', '#tab_5', function(){
            // $('#btn_tab5').trigger('click');
            getTaskWiseView();
        });
        $('body').on('click', '#get_data_t5', function(){
            getTaskWiseView();
        });
        $('.reset').on('click', function(){
            location.reload();
        });
        $('#country_id_5').on('change', function(){
            var country_id=$(this).val();
            if(country_id != '')
            {
                $.ajax('<?=base_url()?>/reports/getClusterByCountry', {
                    type: 'POST',  // http method
                    data: { country_id: country_id },  // data to submit
                    success: function (data) {
                        $('#cluster_id_5').html(data);
                    }
                });

                $.ajax('<?=base_url()?>reports/getUaiByCountry', {
                    type: 'POST',  // http method
                    data: { country_id: country_id },  // data to submit
                    success: function (data) {
                        $('#uai_id_5').html(data);
                    }
                });
                // if(loginrole==1){
                //     $('.get_data').css("background-color","rgb(111, 27, 40)");
                //     $('.get_data').prop("disabled",false);
                // }
            }else{
                $('.get_data_5').css("background-color","rgb(147, 148, 150)");
                $('.get_data_5').prop("disabled",true);
                $('#cluster').html('<option value="">Select Cluster</option>');
                $('#uai_id_5').html('<option value="">Select UAI</option>');
                $('#sub_location_id_5').html('<option value="">Select Sub Location</option>');
                
            }   
        });
        

        $('#uai_id_5').on('change', function(){
            var uai_id=$(this).val();
            
            if(uai_id != '')
            {
                $('.get_data_5').css("background-color","rgb(111, 27, 40)");
                $('.get_data_5').prop("disabled",false);
                $('#cluster_id_5').html('<option value="">Select Cluster</option>');
                $.ajax('<?=base_url()?>reports/getSubLocationByUai', {
                    type: 'POST',  // http method
                    data: { uai_id: uai_id },  // data to submit
                    success: function (data) {
                        $('#sub_location_id_5').html(data);
                    }
                }); 
            } 
            else{
                if(loginrole==1){
                    //empty
                }else{
                    $('.get_data_5').css("background-color","rgb(147, 148, 150)");
                    $('.get_data_5').prop("disabled",true);
                }
                $('#sub_location_id_5').html('<option value="">Select Sub Location</option>');
            
            }   
        });
        $('#cluster_id_5').on('change', function(){
            var cluster_id=$(this).val();
            
            if(cluster_id != '')
            {
                $('.get_data_5').css("background-color","rgb(111, 27, 40)");
                $('.get_data_5').prop("disabled",false);
                $('#uai').html('<option value="">Select Cluster</option>'); 
            } 
            else{
                $('.get_data_5').css("background-color","rgb(147, 148, 150)");
                $('.get_data_5').prop("disabled",true); 
            }   
        });
        
        /*  Mallikharjuna wrote code for loading dashboards from here*/

        function getTaskWiseView(){
            var country=$('select[name="country_id_5"]').val();
            var uai=$('select[name="uai_id_5"]').val();
            var sub_location=$('select[name="sub_location_id_5"]').val();
            var cluster=$('select[name="cluster_id_5"]').val();
            var start_date=$('input[name="start_date_5"]').val();
            var end_date=$('input[name="end_date_5"]').val();
            var task_id=$('select[name="task_id"]').val();
            
            var selectedName = "";
            if(task_id.length > 0){
                const selectBox = document.getElementById("task_id");
                selectedName = selectBox.options[selectBox.selectedIndex].text;
            }
            var query_data = {
                country : country,
                uai : uai,
                sub_location : sub_location,
                cluster : cluster,
                task_id : task_id,
                start_date : start_date,
                end_date : end_date

            };
                $('.div_task_view').html('<h4 class="text-center loading">Please Wait. Getting Data</h4>');
                $.ajax({
                    url : "<?php echo base_url(); ?>dashboard/get_taskwise_data/",
                    data : query_data,
                    type : "POST",
                    dataType : "JSON",
                    error:function(){
                    },
                    success:function(response){
                        if(response.status == 1){
                            var HTML_GENERAL = `<div class="row mt-4">
                                            <div class="col-12">
                                            <div class="card border-0 card-shadow"><h4 class="chart-title">Task Details</h4></div>
                                            </div>
                                            <div class="col-sm-12 col-md-6 col-lg-6">
                                                <div class="card border-0 card-shadow">
                                                    <div class="card-body">
                                                        <h4 class="chart-title">Status (${task_id.length > 0 ? selectedName : 'All'})</h4>
                                                        <div
                                                            class="d-flex justify-content-around align-items-center flex-wrap">
                                                            <div class="map_height" id="task_level"
                                                                style="width:260px;height: 260px;">
                                                            </div>
                                                            <div class="">
                                                                <div class="primary-v9 mt-3">
                                                                    <div class="mb-0 mt-1 pl-2">
                                                                        <span
                                                                            class="chart-legend-title">Submitted</span>
                                                                        <span
                                                                            class="large-bold pl-3">`+response.task_level[0]['y']+`</span>
                                                                    </div>
                                                                </div>
                                                                <div class="primary-v10 mt-3">
                                                                    <div class="mb-0 mt-1 pl-2">
                                                                        <span
                                                                            class="chart-legend-title">Approved</span><span
                                                                            class="large-bold pl-3">`+response.task_level[1]['y']+`</span>
                                                                    </div>
                                                                </div>
                                                                <div class="primary-v11 mt-3">
                                                                    <div class="mb-0 mt-1 pl-2">
                                                                        <span
                                                                            class="chart-legend-title">Rejected</span><span
                                                                            class="large-bold pl-3">`+response.task_level[2]['y']+`</span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-12 col-md-6 col-lg-6">
                                                <div class="card border-0 card-shadow">
                                                    <div class="card-body">
                                                        <h4 class="chart-title">Rejection Reasons (${task_id.length > 0 ? selectedName : 'All'})</h4>
                                                        <div
                                                            class="d-flex justify-content-around align-items-center flex-wrap">
                                                            <div class="map_height" id="rejection_reasons"
                                                                style="width:260px;height: 260px;">
                                                            </div>
                                                            <div class="">
                                                                <div class="primary-v9 mt-3">
                                                                    <div class="mb-0 mt-1 pl-2">
                                                                        <span
                                                                            class="chart-legend-title">Poor Picture Quality</span>
                                                                        <span
                                                                            class="large-bold pl-3">`+response.rejection_reasons[0]['y']+`</span>
                                                                    </div>
                                                                </div>
                                                                <div class="primary-v10 mt-3">
                                                                    <div class="mb-0 mt-1 pl-2">
                                                                        <span
                                                                            class="chart-legend-title">Wrong location</span><span
                                                                            class="large-bold pl-3">`+response.rejection_reasons[1]['y']+`</span>
                                                                    </div>
                                                                </div>
                                                                <div class="primary-v11 mt-3">
                                                                    <div class="mb-0 mt-1 pl-2">
                                                                        <span
                                                                            class="chart-legend-title">Value out of range</span><span
                                                                            class="large-bold pl-3">`+response.rejection_reasons[2]['y']+`</span>
                                                                    </div>
                                                                </div>
                                                                <div class="primary-v3 mt-3">
                                                                    <div class="mb-0 mt-1 pl-2">
                                                                        <span
                                                                            class="chart-legend-title">Others</span><span
                                                                            class="large-bold pl-3">`+response.rejection_reasons[3]['y']+`</span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                            <div class="card border-0 card-shadow"><h4 class="chart-title">Payment Details</h4></div>
                                            </div>
                                            <div class="col-sm-12 col-md-6 col-lg-6">
                                                <div class="card border-0 card-shadow">
                                                    <div class="card-body">
                                                        <h4 class="chart-title">UAI Distribution</h4>
                                                        <div class="map_height" id="uai_wise"
                                                            style="width:100%;height: 600px;">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-12 col-md-6 col-lg-6">
                                                <div class="card border-0 card-shadow">
                                                    <div class="card-body">
                                                        <h4 class="chart-title">Cluster Distribution</h4>
                                                        <div class="map_height" id="cluster_wise"
                                                            style="width:100%;height: 600px;">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-12 col-md-12 col-lg-12">
                                                <div class="card border-0 card-shadow">
                                                    <div class="card-body">
                                                        <h4 class="chart-title">Contributor wise</h4>
                                                        <div class="map_height" id="contributor_wise"
                                                            style="width:100%;height: 600px;">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-12 col-md-12 col-lg-12">
                                                <div class="card border-0 card-shadow">
                                                    <div class="card-body">
                                                        <h4 class="chart-title">Task wise</h4>
                                                        <div class="map_height" id="task_wise"
                                                            style="width:100%;height: 600px;">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>`;
                            $('.div_task_view').html(HTML_GENERAL);
                            task_wise_piechart('task_level', response.task_level, 'Number of records');
                            task_wise_piechart('rejection_reasons', response.rejection_reasons, 'Number of records');
                            horizantal_barchart('task_wise', response.task_wise,"KES");
                            horizantal_barchart('uai_wise', response.uai_wise,'KES');
                            horizantal_barchart('cluster_wise', response.cluster_wise,'KES');
                            horizantal_barchart('contributor_wise', response.contributor_wise,'KES');
                            
                        }
                    }
                }).always(function(response) {
            });
        }

        function task_wise_piechart(divid, data, yaxis_units){
            Highcharts.chart(divid, {
                chart: {
                    plotBackgroundColor: null,
                    plotBorderWidth: null,
                    plotShadow: false,
                    type: 'pie'
                },
                title: {
                    text: '',
                    align: 'left'
                },
                tooltip: {
                    pointFormat: '{series.name}: <b>{point.y}</b>'
                },
                accessibility: {
                    point: {
                        valueSuffix: '%'
                    }
                },
                exporting: {
                    enabled: false
                },
                credits: {
                    enabled: false
                },
                plotOptions: {
                    pie: {
                        cursor: 'pointer',
                        dataLabels: {
                            enabled: false
                        },
                        showInLegend: false
                    }
                },
                
                series: [{
                    name: yaxis_units,
                    data: data
                }]
            });
        }

        function task_wise_barchart(divid, data){
            Highcharts.chart(divid, {
            chart: {
                type: 'bar'
            },
            title: {
                text: '',
            },
            subtitle: {
                text: '',
            },
            xAxis: {
                categories: data.filter(b => b.y != 0).map(a=>a.name),
                // categories: ['Payment Details1', 'Payment Details 2', 'Payment Details 3', 'Payment Details 4', 'Payment Details 5'],
                title: {
                    text: null
                }
            },
            yAxis: {
                min: 0,
                title: {
                    text: '',
                    align: 'high'
                },
                labels: {
                    overflow: 'justify'
                }
            },
            tooltip: {
                valueSuffix: ' millions'
            },
            plotOptions: {
                bar: {
                    dataLabels: {
                        enabled: true
                    }
                }
            },
            credits: {
                enabled: false
            },
            exporting: {
                enabled: false
            },
            series: [
                {
                name: 'Contributor Name',
                color: '#14C9C9',
                data: data.filter(b => b.y != 0).map(a=>a.y),
            }]
            });   
        }
        function horizantal_barchart(divid, data, yaxis_units){
            Highcharts.chart(divid, {
                chart: {
                    type: 'column'
                },
                title: {
                    align: 'left',
                    text: ''
                },
                subtitle: {
                    align: 'left',
                    text: ''
                },
                accessibility: {
                    announceNewData: {
                        enabled: true
                    }
                },
                xAxis: {
                    type: 'category'
                },
                yAxis: {
                    title: {
                        text: yaxis_units
                    }

                },
                exporting: {
                    enabled: false
                },
                credits: {
                    enabled: false
                },
                plotOptions: {
                    series: {
                        borderWidth: 0,
                        dataLabels: {
                            enabled: true,
                            color: '#000',
                            format: '{point.y}', 
                            y: -5, 
                        
                        }
                    }
                },
                tooltip: {
                    headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
                    pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y}</b><br/>'
                },
                series: [
                    { 
                        name: yaxis_units,
                        colorByPoint: true,
                        data: data.filter(b => b.y != 0)
                        
                    }
                ],
            });
        }
        /*  Mallikharjuna wrote code for loading dashboards upto here*/
    </script>