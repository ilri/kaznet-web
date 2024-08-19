<!-- Main content -->
<style>
	.mobile_code{
		position: absolute;
		top: 56px;
		left: 22px;
	}
	.mobile_count{
		padding-left: 80px;
	}
</style>
	<div class="container-fluid">
		<div class="row">
			<div class="col-sm-12 col-md-12 col-lg-12 mt-3">
				<nav>
					<ol class="breadcrumb mb-0 bg-transparent">
						<!-- <li class="breadcrumb-item"><a href="#">Dashboard</a></li> -->
						<li class="breadcrumb-item"><a href="#">Custom Template</a></li>
						<li class="breadcrumb-item active">View Template</li>
					</ol>
				</nav>
			</div>
			<div class="col-sm-12 col-md-12 col-lg-12">
				<div class="col-md-12">
        <div class="box box-warning">
          <div class="box-body ">            
            <!-- Widget: user widget style 1 -->
            <div class="card p-10 col-md-12 mt-10">
              <!-- Add the bg color to the header using any of the bg-* classes -->
              <div class="widget-user-header ">
                <!-- /.widget-user-image -->
                <h3 class="widget-user-username"><?php echo $formname->title; ?></h3>
                <p class="widget-user-username"><?php echo $formname->subject; ?></p>
              </div>
              
              <form><?php
                foreach ($fields as $key => $value) {
                  if($value['type'] == 'text' && $value['subtype'] != 'tel'){ ?>
                    <div class="form-group">
                      <label><?php 
                        echo $value['label']; 
                        if($value['required'] == 1){ ?>
                          <font color="red">*</font><?php
                        }  ?>
                      </label><?php 
                      if($value['subtype'] == 'datetime-local'){ ?>
                        <input type="text" id="datetimepicker5" name="<?php echo $value['name']; ?>" class="<?php echo $value['className']; ?>" <?php if($value['required'] == 1){ echo "required"; } ?>  ><?php
                      }else{ ?>
                        <input type="<?php echo $value['subtype']; ?>" name="<?php echo $value['name']; ?>" class="<?php echo $value['className']; ?>" <?php if($value['required'] == 1){ echo "required"; } ?> ><?php
                        } ?>                            
                    </div><?php
                  }

                  if($value['type'] == 'location'){ ?>
                    <div class="form-group">
                      <label><?php 
                      echo $value['label']; 
                      if($value['required'] == 1){ ?>
                        <font color="red">*</font><?php
                      }  ?>
                    </label>
                    <?php if($value['description'] != NULL){ ?>
                      <i data-toggle="tooltip" data-title="<?php echo $value['description']; ?>" class="fa fa-question-circle" aria-hidden="true"></i>
                    <?php } ?>
                    <input type="<?php echo $value['subtype']; ?>" id="location" name="<?php echo $value['name']; ?>" class="<?php echo $value['className']; ?>">
                    <p class="error red-800"></p>
                    </div><?php
                  }

                  if($value['type'] == 'date'){ ?>
                    <div class="form-group">
                      <label><?php 
                        echo $value['label']; 
                        if($value['required'] == 1){ ?>
                          <font color="red">*</font><?php
                        }  ?>
                      </label>
                      <input type="text" name="<?php echo $value['name']; ?>" class="<?php echo $value['className']; ?> datepicker" <?php if($value['required'] == 1){ echo "required"; } ?> >
                    </div><?php
                  }

                  if($value['type'] == 'month'){ ?>
                    <div class="form-group">
                      <label><?php 
                        echo $value['label']; 
                        if($value['required'] == 1){ ?>
                          <font color="red">*</font><?php
                        }  ?>
                      </label>
                      <input type="text" name="<?php echo $value['name']; ?>" class="<?php echo $value['className']; ?> monthpicker" <?php if($value['required'] == 1){ echo "required"; } ?> autocomplete="off" readonly >
                    </div><?php
                  }

                  if($value['type'] == 'header'){ ?>
                    <div class="form-group">
                      <label><?php echo $value['label'];?></label>
                    </div>
                  <?php }

                  if($value['type'] == 'number'){ ?>
                    <div class="form-group">
                      <label><?php 
                        echo $value['label']; 
                        if($value['required'] == 1){ ?>
                          <font color="red">*</font><?php
                        }  ?>
                      </label>
                      <input type="number" name="<?php echo $value['name']; ?>" class="<?php echo $value['className']; ?>" <?php if($value['required'] == 1){ echo "required"; } ?> >
                    </div><?php
                  }

                  if($value['type'] == 'radio-group'){ ?>
                    <div class="form-group">
                      <label><?php 
                        echo $value['label']; 
                        if($value['required'] == 1){ ?>
                          <font color="red">*</font><?php
                        }  ?>
                      </label><?php
                      if($value['inline'] == 'true'){ ?>
                        <div class="form-check"><?php
                          foreach ($value['options'] as $key => $option) { ?>                                
                            <label class="<?php if($value['inline'] == 'true'){ echo "radio-inline"; } ?>" >
                              <input type="radio" name="<?php echo $value['name']; ?>"  class="<?php if($value['className'] != ''){ echo $value['className']; }  ?>" value = "<?php echo $option['value']; ?>" <?php if($option['selected'] == 'true'){ echo "checked"; } ?> <?php if($value['required'] == 1){ echo "required"; } ?> ><?php echo $option['label'] ?>
                            </label><?php
                          } ?>
                        </div><?php
                      }else{
                        foreach ($value['options'] as $key => $option) { ?>
                        <div class="form-check">
                          <label class="<?php if($value['inline'] == 'true'){ echo "radio-inline"; } ?>" >
                            <input type="radio" name="<?php echo $value['name']; ?>"  class="<?php if($value['className'] != ''){ echo $value['className']; }  ?>" value = "<?php echo $option['value']; ?>" <?php if($option['selected'] == 'true'){ echo "checked"; } ?> <?php if($value['required'] == 1){ echo "required"; } ?> ><?php echo $option['label'] ?>
                          </label>
                        </div><?php
                        }
                      } ?>                              
                    </div><?php
                  }

                  if($value['type'] == 'ranking_system'){ ?>
                    <div class="col-md-12 ranking_system">
                      <div class="card p-10">
                        <div class="form-group">
                          <label><?php 
                            echo $value['label']; 
                            if($value['required'] == 1){ ?>
                              <font color="red">*</font><?php
                            }  ?>
                          </label>
                          <div class="row">
                            <?php $rankinglength = count($value['options']);
                            foreach ($value['options'] as $key => $option) { ?>
                              <div class="col-md-6">
                                <label style="margin-left:20px;"><?php echo $option['label']; ?></label>
                              </div>
                              <div class="col-md-6">
                                <div class="row">
                                  <?php for ($i = 1; $i <= $rankinglength; $i++) { ?>
                                    <div class="col-sm-1">
                                      <label>
                                        <input type="radio" name="`+option.name+`" class="ranking" value = "`+i+`" data-required="`+req_val+`"><?php echo $i; ?>
                                      </label>
                                    </div>
                                  <?php } ?>
                                </div>
                              </div>
                            <?php } ?>
                          </div>
                          <p class="error red-800"></p>
                        </div>
                        <p class="ranking_systemerror red-800"></p>
                      </div>
                    </div>
                  <?php }

                  if($value['type'] == 'checkbox-group'){ ?>
                    <div class="form-group">
                      <label><?php 
                        echo $value['label']; 
                        if($value['required'] == 1){ ?>
                          <font color="red">*</font><?php
                        }  ?>
                      </label><?php
                      if($value['inline'] == 'true'){ ?>
                        <div class="form-radio"><?php
                          foreach ($value['options'] as $key => $option) { ?>
                            <label class="<?php if($value['inline'] == 'true'){ echo "checkbox-inline"; } ?>" >
                              <input type="checkbox" name="<?php echo $value['name']; ?>"  class="<?php if($value['className'] != ''){ echo $value['className']; }  ?>" value = "<?php echo $option['value']; ?>" <?php if($option['selected'] == 'true'){ echo "checked"; } ?> <?php if($value['required'] == 1){ echo "required"; } ?> ><?php echo $option['label'] ?>
                            </label><?php
                          } ?>
                        </div><?php 
                      }else{
                        foreach ($value['options'] as $key => $option) { ?>
                          <div class="form-radio">
                            <label class="<?php if($value['inline'] == 'true'){ echo "checkbox-inline"; } ?>" >
                              <input type="checkbox" name="<?php echo $value['name']; ?>"  class="<?php if($value['className'] != ''){ echo $value['className']; }  ?>" value = "<?php echo $option['value']; ?>" <?php if($option['selected'] == 'true'){ echo "checked"; } ?> <?php if($value['required'] == 1){ echo "required"; } ?> ><?php echo $option['label'] ?>
                            </label>
                          </div><?php
                        }
                      } ?>
                    </div><?php
                  }

                  if($value['type'] == 'textarea'){ ?>
                    <div class="form-group">
                      <label><?php 
                        echo $value['label']; 
                        if($value['required'] == 1){ ?>
                          <font color="red">*</font><?php
                        }  ?>
                      </label>
                      <textarea name="<?php echo $value['name']; ?>" class="<?php echo $value['className']; ?>" <?php if($value['required'] == 1){ echo "required"; } ?> ></textarea>
                    </div><?php
                  }

                  if($value['type'] == 'select'){ ?>
                    <div class="form-group">
                      <label><?php 
                        echo $value['label']; 
                        if($value['required'] == 1){ ?>
                          <font color="red">*</font><?php
                        }  ?>
                      </label>
                      <select name="<?php echo $value['name']; ?>" <?php if($value['multiple'] == 'true'){ echo "multiple"; } ?> class="form-control" <?php if($value['required'] == 1){ echo "required"; } ?> >
                        <option value="">Select</option><?php
                        foreach ($value['options'] as $key => $option) { ?>
                          <option value = "<?php echo $option['value']; ?>" <?php if($option['selected'] == 'true'){ echo "selected"; } ?> ><?php echo $option['label']; ?></option> <?php
                         } ?>
                      </select>
                    </div><?php
                  }

                  if($value['type'] == 'file'){ ?>
                    <div class="form-group">
                      <label><?php 
                        echo $value['label']; 
                        if($value['required'] == 1){ ?>
                          <font color="red">*</font><?php
                        }  ?>
                      </label>
                      <input type="file" name="<?php echo $value['name']; ?>[]" class="<?php echo $value['className']; ?> <?php echo $value['subtype']; ?>" data-maxfile = "<?php echo $value['maxlength']; ?>" multiple >
                      <?php if($value['subtype'] == 'image'){ ?>
                        <p class="imageerror red-800"></p>
                      <?php } ?>

                      <?php if($value['subtype'] == 'document'){ ?>
                        <p class="documenterror red-800"></p>
                      <?php } ?>

                      <?php if($value['subtype'] == 'excel'){ ?>
                        <p class="excelerror red-800"></p>
                      <?php } ?>
                      
                    </div><?php
                  }
                } ?>                      
              </form>
            </div>              
           <!-- /.widget-user -->               
          </div>
          <!--/box body -->
        </div>
        <!--/box -->
      </div>
			</div>
		</div>
	</div>
</div>
<!-- /Main content -->