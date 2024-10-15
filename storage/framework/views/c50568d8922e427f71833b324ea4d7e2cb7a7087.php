<?php $__env->startSection(config('elseyyid-location.content_section')); ?>
        <div class="col-md-12">

            <?php $lang_region = LaravelLocalization::getSupportedLocales()[str_replace('_','-',$lang)]['regional']; ?>
            <?php $lang_native = LaravelLocalization::getSupportedLocales()[str_replace('_','-',$lang)]['native']; ?>
            <h6 class="font-weight-semibold fs-16 text-center mb-4"><?php echo e(__('Editing Language')); ?>: <?php echo e(ucfirst($lang_native)); ?> <span class="text-muted fs-12 ml-1"><?php echo e(ucfirst($lang)); ?></span></h6>

            <input class="form-control mb-6 mt-4 text-muted fs-12 font-weight-semibold" id="search_string"  type="text" onkeyup="searchStrings()" placeholder="<?php echo e(__('Filter strings...')); ?>">

            <div class="card language-editor-box">
                <div class="card-table table-responsive">
    
                    <table class="table" id="strings">
                        <thead>
                            <tr>
                                <th class="text-muted fs-12 font-weight-semibold pl-4"><?php echo e(__('Strings')); ?></th>
                                <th class="text-muted fs-12 font-weight-semibold"><?php echo e(__('Translations')); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $list; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td class="hidden" width="10px">
                                        <input type="checkbox" name="ids_to_edit[]" value="<?php echo e($value->id); ?>"/>
                                    </td>
                                    <?php $__currentLoopData = $value->toArray(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $element): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php if($key !== 'code'): ?>
                                            <?php if($key === 'en'): ?>
                                                <td class="w-50 pl-4" style="vertical-align: middle">
                                                    <div data-name="<?php echo e($key); ?>"><?php echo e($element); ?></div>
                                                </td>
                                            <?php else: ?>
                                                <td class="w-50">
                                                    <input class="form-control w-100" data-pk="<?php echo e($value->code); ?>" data-name="<?php echo e($key); ?>" type="text" value="<?php echo e($element); ?>" placeholder="<?php echo e(__('enter translation')); ?>">
                                                </td>
                                            <?php endif; ?>
                                        <?php endif; ?>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>

                <div class="fixed-bottom text-center pl-9 ml-9">
                    <div class="btn btn-primary pl-9 pr-9 mb-5" id="save_strings" data-lang="<?php echo e($lang); ?>"><?php echo e(__('Save')); ?></div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('js'); ?>
    <script>
        let loading = `<span class="loading">
						<span style="background-color: #fff;"></span>
						<span style="background-color: #fff;"></span>
						<span style="background-color: #fff;"></span>
						</span>`;
        $(document).ready(function() {
       
            $('#save_strings').click(function() {

                document.getElementById("save_strings").disabled = true;
                document.getElementById("save_strings").innerHTML = loading;
                document.querySelector('#loader-line')?.classList?.remove('hidden'); 

                var formData = new FormData();
                var inputData = [];

                $('table input[type="text"]').each(function() {
                    var value = $(this).val();
                    inputData.push(value);
                });

                var jsonData = JSON.stringify(inputData);
                formData.append('data', jsonData);
                formData.append('lang', $(this).data('lang'));

                $.ajax({
                    type: "post",
                    headers: {
                        'X-CSRF-TOKEN': "<?php echo e(csrf_token()); ?>",
                    },
                    url: "/app/admin/settings/languages/lang/update-all",
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(data) {
                        toastr.success("<?php echo e(__('Strings saved successfully')); ?>");
                        document.getElementById("save_strings").disabled = false;
                        document.getElementById("save_strings").innerHTML = "<?php echo e(__('Save')); ?>";
                        document.querySelector('#loader-line')?.classList?.add('hidden');
                    },
                    error: function(data) {
                        var err = data.responseJSON.errors;
                        $.each(err, function(index, value) {
                            toastr.error(value);
                        });
                        document.getElementById("save_strings").disabled = false;
                        document.getElementById("save_strings").innerHTML = "<?php echo e(__('Save')); ?>";
                        document.querySelector('#loader-line')?.classList?.add('hidden');
                    }
                });
                return false;
            });
        });

        function searchStrings() {

            var input, filter, table, tr, td, i, j, txtValue;
            input = document.getElementById("search_string");
            filter = input.value.toUpperCase();
            table = document.getElementById("strings");
            tr = table.getElementsByTagName("tr");

            for (i = 0; i < tr.length; i++) {
                var foundMatch = false;
                td = tr[i].getElementsByTagName("td");

                if (td.length > 0) {
                    for (j = 0; j < td.length; j++) {
                        var divElement = td[j].querySelector("div[data-name='en']");
                        var inputElement = td[j].querySelector("input");
                        if (divElement && divElement.textContent.toUpperCase().indexOf(filter) > -1) {
                            foundMatch = true;
                            break;
                        } else if (inputElement && inputElement.value.toUpperCase().indexOf(filter) > -1) {
                            foundMatch = true;
                            break;
                        }
                    }
                }

                if (foundMatch) {
                    tr[i].style.display = "";
                } else {
                    tr[i].style.display = tr[i].parentNode.tagName === 'THEAD' ? 'table-row' : 'none';
                }
            }
        }
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make(config('elseyyid-location.layout'), \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/mystudentbot.com/public_html/resources/views/vendor/langs/list.blade.php ENDPATH**/ ?>