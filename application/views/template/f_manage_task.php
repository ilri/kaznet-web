    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12 col-md-12 col-lg-12 mt-3">
                <nav>
                    <ol class="breadcrumb mb-0 bg-transparent">
                        <li class="breadcrumb-item"><a href="#">Custom Tasks</a></li>
                        <li class="breadcrumb-item active"> Manage Assigned Tasks</li>
                    </ol>
                </nav>
            </div>
            <div class="col-sm-12 col-md-12 col-lg-12">
              <div class="card mt-3 border-0">

                  <ul class="nav nav-tabs border-bottom-0 bg-transparent mb-3">
                      <li class="nav-item"><a class="nav-link active" href="#Htask" data-toggle="tab">Custom Tasks</a></li>
                  </ul>
              
                  <div class="tab-content">

                      <!-- Htasks Tab -->
                      <div class="tab-pane active" id="Htask">
                          <div class="table-responsive">
                              <!-- <table id="example" class="table table-striped" style="width:100%">
                                  
                              </table> -->
                              <!-- <table class="table tbl_manage_survey"> -->
                              <table id="example" class="table table-striped" style="width:100%">
                                <thead class="bg-dataTable">
                                    <tr>
                                        <th>Task</th>
                                        <!-- <th>Task Type</th> -->
                                        <th>Total Assigned </th>
                                        <th>Not started </th>
                                        <th>Active </th>
                                        <!-- <th>Approved</th>
                                        <th>Rejected</th> -->
                                        <th>Expired </th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($surveys_ht as $key => $survey) { ?>
                                    <tr>
                                        <td>
                                            <a href="<?php echo base_url(); ?>FormController/f_task_contributer/<?php echo $survey['id']; ?>" class="td-color pl-0"><?php echo $survey['title']; ?></a>
                                            <!-- <a href="#" class="td-color pl-0"><?php echo $survey['title']; ?></a> -->
                                        </td>
                                        <td><?php echo $survey['assigned']; ?></td>
                                        <td><?php echo $survey['nstotal']; ?></td>
                                        <td><?php echo $survey['actotal']; ?></td>
                                        <td><?php echo $survey['extotal']; ?></td>
                                        <!-- <td><span>10</span> <span class="pl-2 cursor" data-toggle="modal"
                                                data-target="#remainderModal"><img
                                                    src="<?php echo base_url(); ?>include/assets/images/remainder.svg"></span></td>
                                        <td>30</td>
                                        <td>30</td>
                                        <td>20</td>
                                        <td>10</td> -->
                                        <td class="text-right">
                                            <!-- <button class="btn btn-outline-dark mt-0" data-toggle="modal" data-target="#assignSurveys">Assign Task</button>
                                            <button class="btn btn-outline-dark mt-0">View Date</button> -->
                                            <a class="btn btn-outline-dark mt-0" href="<?php echo base_url(); ?>FormController/f_assign_task/<?php echo $survey['id']; ?>">Assign Task</a>
                                        </td>
                                    </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                          </div>
                      </div>

                  </div>
              </div>
          </div>
            
        </div>
    </div>
</div>

<!--Start assignSurveys Modal PopUp -->
<div class="modal" id="assignSurveys">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 p-2">
            <div class="modal-header border-0">
                <h4 class="modal-title">Assign Task</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body border-0">
                <div class="row">
                    <div class="col-sm-12 col-md-12 col-lg-12">
                        <div class="form-group">
                            <label class="label-text-1">Task Name</label>
                            <select class="form-control">
                                <option>Task Name</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-12 col-lg-12">
                        <div class="form-group">
                            <label class="label-text-1">Location</label>
                            <select class="form-control">
                                <option>Country</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-12 col-lg-12">
                        <div class="form-group">
                            <div class="form-check-inline">
                                <label class="form-check-label">
                                    <input type="radio" class="form-check-input" name="optradio"> UAI
                                </label>
                            </div>
                            <div class="form-check-inline">
                                <label class="form-check-label">
                                    <input type="radio" class="form-check-input" name="optradio" checked> Cluster
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-12 col-lg-12">
                        <div class="form-group">
                            <label class="label-text-1">Cluster</label>
                            <select class="form-control">
                                <option>Cluster</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-sm-12 col-md-12 col-lg-12">
                        <div class="form-group">
                            <label class="label-text-1">Contributer</label>
                            <select class="form-control">
                                <option>Contributer</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-12 col-lg-12">
                        <div class="row">
                            <div class="col-sm-12 col-md-6 col-lg-6">
                                <div class="form-group">
                                    <label class="label-text-1">Start Date</label>
                                    <input type="date" name="" class="form-control">
                                </div>
                            </div>

                            <div class="col-sm-12 col-md-6 col-lg-6">
                                <div class="form-group">
                                    <label class="label-text-1">End Date</label>
                                    <input type="date" name="" class="form-control">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-12 col-lg-12">
                        <div class="form-group">
                            <div class="form-check-inline">
                                <label class="form-check-label">
                                    <input type="checkbox" class="form-check-input" value=""> Make it recurrent
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-12 col-lg-12">
                        <label class="label-text-1">Share As</label>
                        <div class="form-group">
                            <div class="form-check-inline">
                                <label class="form-check-label">
                                    <input type="checkbox" class="form-check-input" value="" checked>Notification
                                </label>
                            </div>
                            <div class="form-check-inline">
                                <label class="form-check-label">
                                    <input type="checkbox" class="form-check-input" value=""> Email
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-12 col-lg-12">
                        <div class="d-flex justify-content-between">
                            <button class="btn btn-outline-dark">Cancel</button>
                            <button class="btn btn-submit text-white">Send</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--End assignSurveys Modal PopUp -->

<!--Start Remainder Modal PopUp -->
<div class="modal" id="remainderModal">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 p-2">
            <div class="modal-header border-0">
                <h4 class="modal-title">Send Reminder</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body border-0">
                <div class="row">
                    <div class="col-sm-12 col-md-12 col-lg-12">
                        <div class="form-group">
                            <label class="label-text-1">Task Name</label>
                            <select class="form-control">
                                <option>Task Name</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="label-text-1">Subject</label>
                            <input type="text" name="" class="form-control" placeholder="Enter Text">
                        </div>
                        <div class="form-group">
                            <label class="label-text-1">Message </label>
                            <textarea type="text" name="" class="form-control" placeholder="Enter Text"
                                rows="5"></textarea>
                        </div>
                        <div class="form-group">
                            <div class="form-check-inline">
                                <label class="form-check-label">
                                    <input type="checkbox" class="form-check-input" value="" checked>Notification
                                </label>
                            </div>
                            <div class="form-check-inline">
                                <label class="form-check-label">
                                    <input type="checkbox" class="form-check-input" value=""> Email
                                </label>
                            </div>
                        </div>
                        <div class="d-flex justify-content-between">
                            <button class="btn btn-outline-dark">Cancel</button>
                            <button class="btn btn-submit text-white">Send</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--End Remainder Modal PopUp -->