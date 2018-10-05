$(document).ready(function () {
    //$.datepicker.regional[""].dateFormat = 'dd/mm/yy';
    //$.datepicker.setDefaults($.datepicker.regional['']);
    var dtTable = $('#dataTableBuilder').dataTable(
        {
            dom: 'lfrBptip',
            "serverSide": true,
            "processing": true,
            "pageLength": 25,
            buttons: [
                //'pdfHtml5'
                {
                    extend: 'pdfHtml5',
                    messageTop: function(){
                        start = $('#filter-created_at-start').val();
                        end = $('#filter-created_at-end').val();
                        if(!start){
                            start = "From Beginning";
                        }
                        if(!end){
                            end = "Today";
                        }
                        if(start === end) {
                            output = start;
                        } else {
                            output = start + " to " + end;
                        }
                        return output;
                    }
                }
            ],
            "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
            "ajax": {
                "url": "",
                data: function(d) {
                    d.filters = {
                        created_at: {
                            start: $('#filter-created_at-start').val(),
                            end: $('#filter-created_at-end').val()
                        },
                        /*date_assigned: {
                            start: $('#filter-date_assigned-start').val(),
                            end: $('#filter-date_assigned-end').val()
                        }*/
                    };

                    /*d.date_submit = {
                        start: $('#filter-date_submitted-start').val(),
                        end: $('#filter-date_submitted-end').val()
                    }*/


                    /*d.start = $('#filter-date_submitted-start').val();
                    d.end = $('#filter-date_submitted-end').val();*/
                }
            },
            "columns": JSON.parse(dataColumns),
            "initComplete": function () {

                this.api().columns().every(function () {
                    var column = this;
                    var field_name = column.dataSrc();
                    //console.log(field_name);
                    field_name = field_name.replace(".", "-");
                    var selector = "#filter-" + field_name;

                    //console.log(selector);
                    var $input = $(selector);

                    //console.log($input.length);
                    if ($input.length) {

                        $input.on('change', function () {
                            column.search($(this).val(), false, false, true).draw();
                        });
                    }

                    var f_start = "#filter-" + field_name + "-start";
                    var f_end = "#filter-" + field_name + "-end";

                    //console.log(f_start, f_end);

                    if ($(f_start).length && $(f_end).length) {
                        //console.log("found between");
                        $(f_start).on('change', function () {
                            //column.search($(f_start).val()+","+$(f_end).val(), false, false, true).draw();
                            column.search("", false, false, true).draw();
                            //this.search().draw();
                        });

                        $(f_end).on('change', function () {
                            //column.search($(f_start).val()+","+$(f_end).val(), false, false, true).draw();
                            column.search("", false, false, true).draw();
                            //this.search().draw();
                        });
                    }




                });



            }
        }
    );

    /*$('#filter-date_submitted-start').on('change', function() {
        dtTable.ajax.reload();
    });

    $('#filter-date_submitted-end').on('change', function() {
        dtTable.ajax.reload();
    });*/


});