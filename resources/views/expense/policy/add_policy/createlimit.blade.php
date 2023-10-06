


@extends('layouts.index')
@section('content')
<style>
 .status-button {
background-color:#17c964;
 border-radius: 30px;
}

.status-button:hover{
    background-color:#17c964;
}
.inactive-button {
background-color:#f5a524;
 border-radius: 30px;
}

.inactive-button:hover{
    background-color:#f5a524;
}

.icon-spacing {
    margin-left: 10px; /* Adjust the value to control the spacing */
    display: inline-block; /* Ensures the span takes up space */
}


.word {
 margin-left: 10px; 
 }
                            

</style>

<!-- Page Wrapper -->
<div class="page-wrapper">
<!-- Page Content -->
<div class="content container-fluid">
<!-- row -->
    <div class="row">
        <div class="col-md-12 stretch-card">
            <div class="card">
                <div class="card-body">
                    <div class="col-md-12">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Add Rate Definition</h5>
                            </div>
                <div class="modal-body">
                    <div class="card tab-box">
						<div class="row user-tabs">
							<div class="col-lg-12 col-md-12 col-sm-12 line-tabs">
								<ul class="nav nav-tabs nav-tabs-bottom">
									<li class="nav-item"><a href="#emp_profile" data-toggle="tab" class="nav-link">Expense Policy</a></li>
									<li class="nav-item"><a href="#leave_plan" data-toggle="tab" class="nav-link active">Rate Definition</a></li>
									<li class="nav-item"><a href="#bank_statutory" data-toggle="tab" class="nav-link">Policy Enforcement</a></li>
                                    <li class="nav-item"><a href="#bank_statutory" data-toggle="tab" class="nav-link">Complete</a></li>
								</ul>
							</div>
						</div> 
                    </div>
                            <form method="POST" action="{{ route('rate-limits.store', ['rateDefinition' => $rateDefinition->id]) }}">
                                @csrf
<!--                                
                                <!-- Grade -->
                                <div class="mt-4">
                                    <label for="grade" class="block font-medium text-sm text-gray-700">{{ __('Grade') }}</label>
                                    <div class="mt-2">
                                        <button id="toggle-grades" type="button" class="bg-blue-500 text-black py-2 px-4 rounded-full">Select Grade</button>
                                    </div>
                                    <div id="grade-checkboxes" style="display: none;">
                                        @foreach ($grades as $grade)
                                            <label class="block mt-1">
                                                <input type="checkbox" name="grade[]" value="{{ $grade->id }}" class="mr-2">{{ $grade->name }}
                                            </label>
                                        @endforeach
                                    </div>
                                </div>
                                
                                <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
                                <script>
                                    $(document).ready(function () {
                                        $('#toggle-grades').click(function () {
                                            $('#grade-checkboxes').toggle();
                                        });
                                    });
                                </script>
                            <!-- <div class="col-sm-6">
    <div class="form-group">
        <label for="grade">Grade:</label>
        <select class="form-control" id="grade" name="grade">
            <option value="" selected>Select Grade</option>
            @foreach ($grades as $grade)
                <option value="{{ $grade->id }}">{{ $grade->name }}</option>
            @endforeach
        </select>
        @error('grade')
            <small class="text-danger">{{ $message }}</small>
        @enderror
    </div>
</div>  -->
<!-- <style>
    * {
        box-sizing: border-box;
    }

    a {
        text-decoration: none;
        color: #379937;
    }

    body {
        margin: 40px;
    }

    .dropdown {
        position: relative;
        font-size: 14px;
        color: #333;
    }

    .dropdown-list {
        padding: 12px;
        background: #fff;
        position: absolute;
        top: 30px;
        left: 2px;
        right: 2px;
        box-shadow: 0 1px 2px 1px rgba(0, 0, 0, .15);
        transform-origin: 50% 0;
        transform: scale(1, 0);
        transition: transform .15s ease-in-out .15s;
        max-height: 66vh;
        overflow-y: scroll;
    }

    .dropdown-option {
        display: inline-block;
        margin-right: 20px;
        padding: 8px 12px;
        opacity: 0;
        transition: opacity .15s ease-in-out;
    }

    .dropdown-label {
        display: block;
        height: 30px;
        background: #fff;
        border: 1px solid #ccc;
        padding: 6px 12px;
        line-height: 1;
        cursor: pointer;

        &:before {
            content: '▼';
            float: right;
        }
    }

    &.on {
        .dropdown-list {
            transform: scale(1, 1);
            transition-delay: 0s;

            .dropdown-option {
                opacity: 1;
                transition-delay: .2s;
            }
        }

        .dropdown-label:before {
            content: '▲';
        }
    }

    [type="checkbox"] {
        position: relative;
        top: -1px;
        margin-right: 4px;
    }
</style>

<h1>Dropdown Checkboxes</h1>

<div class="col-sm-6">
    <div class="form-group">
        <label for="grade">Grade:</label>
        <div class="grade-dropdown" data-control="checkbox-dropdown">
            <label class="dropdown-label">Select Grade</label>

            <div class="grade-dropdown-list">
                <label class="grade-dropdown-option">
                    <input type="checkbox" data-toggle="check-all" />
                    Check All
                </label>

                @foreach ($grades as $grade)
                    <label class="grade-dropdown-option">
                        <input type="checkbox" name="selected-grades[]" value="{{ $grade->id }}" />
                        {{ $grade->name }}
                    </label>
                @endforeach
            </div>
        </div>
        @error('grade')
            <small class="text-danger">{{ $message }}</small>
        @enderror
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>(function ($) {
    var CheckboxDropdown = function (el) {
        var _this = this;
        this.isOpen = false;
        this.areAllChecked = false;
        this.$el = $(el);
        this.$label = this.$el.find('.dropdown-label');
        this.$checkAll = this.$el.find('[data-toggle="check-all"]').first();
        this.$inputs = this.$el.find('[type="checkbox"]');

        this.onCheckBox();

        this.$label.on('click', function (e) {
            e.preventDefault();
            _this.toggleOpen();
        });

        this.$checkAll.on('change', function () {
            _this.onCheckAll();
        });

        this.$inputs.on('change', function () {
            _this.onCheckBox();
        });
    };

    CheckboxDropdown.prototype.onCheckBox = function () {
        this.updateStatus();
    };

    CheckboxDropdown.prototype.updateStatus = function () {
        var checked = this.$el.find(':checked');

        this.areAllChecked = false;
        this.$checkAll.prop('checked', false);

        if (checked.length <= 0) {
            this.$label.html('Select Options');
        } else if (checked.length === 1) {
            this.$label.html(checked.parent('label').text());
        } else if (checked.length === this.$inputs.length) {
            this.$label.html('All Selected');
            this.areAllChecked = true;
            this.$checkAll.prop('checked', true);
        } else {
            this.$label.html(checked.length + ' Selected');
        }
    };

    CheckboxDropdown.prototype.onCheckAll = function () {
        var checkAll = this.$checkAll.prop('checked');
        this.$inputs.prop('checked', checkAll);

        this.updateStatus();
    };

    CheckboxDropdown.prototype.toggleOpen = function (forceOpen) {
        var _this = this;

        if (!this.isOpen || forceOpen) {
            this.isOpen = true;
            this.$el.addClass('on');
            $(document).on('click', function (e) {
                if (!$(e.target).closest('[data-control]').length) {
                    _this.toggleOpen();
                }
            });
        } else {
            this.isOpen = false;
            this.$el.removeClass('on');
            $(document).off('click');
        }
    };

    var gradeDropdowns = document.querySelectorAll('[data-control="checkbox-dropdown"]');
    for (var i = 0, length = gradeDropdowns.length; i < length; i++) {
        new CheckboxDropdown(gradeDropdowns[i]);
    }
})(jQuery);
</script> -->



                
                                

                                
                                <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="uom">Region:</label>
                                    <select class="form-control" id="region" name="region">
                                    <option value="Bumthang">Bumthang</option>
                                    <option value="Gelephu">Gelephu</option>
                                    <option value="Mongar">Mongar</option>
                                    <option value="Paro">Paro</option>
                                    <option value="Phuntsholing">Phuntsholing</option>
                                    <option value="Punakha">Punakha</option>
                                    <option value="Sumdrup Jongkhar">Sumdrup Jongkhar</option>
                                    <option value="Samtse">Samtse</option>
                                    <option value="Thimphu">Thimphu</option>
                                    <option value="Trashigang">Trashigang</option>
                                    <option value="Tsirang">Tsirang</option>
                                    </select>
                                    @error('region')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror  
                                </div>
                                </div>
                                <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="limit_amount">Limit Amount:</label>
                                    <input type="number" id="limit_amount" name="limit_amount" class="form-control" required>
                                    @error('limit_amount')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror  
                                </div>
                              </div>

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="start_date">Start Date:</label>
                                    <input type="date" id="start_date" name="start_date" class="form-control" required>
                                    @error('start_date')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror  
                                </div>
                            </div>

                            <div class="col-sm-6">
                            <div class="form-group">
                                    <label for="end_date">End Date:</label>
                                    <input type="date" id="end_date" name="end_date" class="form-control" required>
                                    @error('end_date')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror  
                                </div>
                            </div>
                                <div class="col-sm-6">
                                <div class="form-group md-3">
                                    <label for="status">Status:</label>
                                    <select class="form-control" id="status" name="status">
                                        <option disabled selected>Choose status:</option>
                                        <option value="active">Active</option>
                                        <option value="inactive">Inactive</option>
                                    </select>
                                    @error('status')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror   
                                </div>
                                </div>
                                    <!-- Modal footer -->
                                    <div class="modal-footer justify-content-middle mt-3">
                                    <button type="submit" class="btn btn-primary">Create Limit</button>
                                    &nbsp;  &nbsp;   &nbsp;
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                    &nbsp;  &nbsp;   &nbsp;
                                    </div>
                            </form>
           
                    <!-- /End  Limit-->
                    
                    </div>
                </div>
                    </div>
                </div>
            </div>       
        </div>
     <!-- /row --> 
</div>
<!-- Page Content -->
</div>
<!-- /Page Wrapper -->

                
 <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
 <script>
    function redirectToYearEndProcessing(url) {
        window.location.href = url;
    }
</script>

<script>
$(document).ready(function() {
    $('#selectAllCheckbox').change(function() {
        $('input[type="checkbox"]').prop('checked', this.checked);
    });
});
</script>

<script>
$(document).ready(function () {
    $("#example").DataTable();
});
</script>
<script>
    $(document).ready(function() {
    // Initialize datetimepicker
    $('.datetimepicker').datetimepicker({
        format: 'YYYY-MM-DD', // Set the desired date format
        // Add any other options you need
    });
});
</script>







@endsection



