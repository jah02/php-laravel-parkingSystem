$(document).ready(function () {
    let loadData = true;
    let tableMain = $('#tableMain');
    let tableMainBody = $('#tableMainBody');
    let tableHistory = $('#tableHistory');
    let tableHistoryBody = $('#tableHistoryBody');
    let tabHistory = $('#tabHistory');
    let tabMain = $('#tabMain');
    let loadingWheel = $('#loadingWheel');
    let errorBox = $('#errorBox');
    let errorTextObject = $('#errorText');
    let pageNumHistory = 1;
    let pageNumMain = 1;
    let searchParams = new URLSearchParams(window.location.search);
    let endPageHistory = false;
    let endPageMain = false;
    let searchInputMain = $('#searchInputMain');
    let searchInputHistory = $('#searchInputHistory');

    tabHistory.on('click', function () {
        tableMain.attr('hidden', true);

        if(!tabHistory.hasClass('active')) {
            switchActiveTab(tabHistory, tabMain);
        }

        loadingWheel.attr('hidden', false);

        if(loadData) {
            doAjaxHistory();
        } else {
            tableHistory.attr('hidden', false);
            loadingWheel.attr('hidden', true);
        }
    });

    tabMain.on('click', function () {
        tableHistory.attr('hidden', true);
        tableMain.attr('hidden', false);

        loadingWheel.attr('hidden', true);
        hideErrorText(errorBox);

        if(!tabMain.hasClass('active')) {
            switchActiveTab(tabHistory, tabMain);
        }
    });

    $('#reloadHistory').on('click', function () {
        $('#tableHistoryBody tr').remove();
        loadingWheel.attr('hidden', false);
        if(endPageHistory) {
            pageNumHistory = 1;
        }
        doAjaxHistory();
    });

    $(window).scroll(function() {
        if($(window).scrollTop() > 1200) {
            $('#buttonToTop').attr('hidden', false);
        } else {
            $('#buttonToTop').attr('hidden', true);
        }

        //Check for bottom
        if($(window).scrollTop() + $(window).height() === $(document).height()) {
            //Check which table
            if(tabHistory.hasClass('active')) {
                loadingWheel.attr('hidden', false);
                if(!endPageHistory) {
                    pageNumHistory++;
                }
                doAjaxHistory();
            } else {
                loadingWheel.attr('hidden', false);
                if(!endPageMain) {
                    pageNumMain++;
                }
                doAjaxMain();
            }
        }
    });

    $('#buttonToTop').on('click', function () {
        $(window).scrollTop(0);
    });

    searchInputMain.on('keyup', function () {
        let input = $(this).val();
        let length = input.length;

        if(length > 2) {
            doSearchAjaxMain(input);
        } else {
            $('.trMain').attr('hidden', false);
            $('.trSearchMain').attr('hidden', true);
        }
    });

    //Prevent text remove bug
    searchInputMain.change(function () {
        if($(this).val().length === 0) {
            $('.trMain').attr('hidden', false);
            $('.trSearchMain').attr('hidden', true);
        }
    });

    searchInputHistory.on('keyup', function () {
        let input = $(this).val();
        let length = input.length;

        if(length > 2) {
            doSearchAjaxHistory(input);
        } else {
            $('.trHistory').attr('hidden', false);
            $('.trSearchHistory').attr('hidden', true);
        }
    });

    //Prevent text remove bug
    searchInputHistory.change(function () {
        if($(this).val().length === 0) {
            $('.trHistory').attr('hidden', false);
            $('.trSearchHistory').attr('hidden', true);
        }
    });

    function switchActiveTab(tab1, tab2) {
        if(tab1.hasClass('active')) {
            tab1.removeClass('active');
            tab2.addClass('active');
        } else {
            tab2.removeClass('active');
            tab1.addClass('active');
        }
    }

    function showErrorText(errorBox, errorTextObject, errorText) {
        errorBox.attr('hidden', false);
        errorTextObject.text(errorText);
    }

    function hideErrorText(errorBox) {
        errorBox.attr('hidden', true);
    }

    function doAjaxHistory() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            url: `${url_history}?page=${pageNumHistory}`,
            type: 'POST',
            success: function (data, status, xhr) {
                if(data.vehiclesHistory[0] != null) {
                    hideErrorText(errorBox);
                    tableHistory.attr('hidden', false);
                    loadingWheel.attr('hidden', true);
                    loadData = false;

                    $.each(data.vehiclesHistory, function (i ,val) {
                        tableHistoryBody.append(
                            '<tr class="trHistory">' +
                            `<td>${val.license_plate}</td>` +
                            `<td>${val.vehicle_type}</td>` +
                            `<td>${val.arrival_time}</td>` +
                            `<td>${val.departure_time}</td>` +
                            `<td>` +
                            "<a href=" + url_details.replace(/.$/, `${val.car_id}`) + " class=\"btn btn-sm btn-info\">Details</a>" +
                            `</td>` +
                            '</tr>'
                        );
                    });
                } else {
                    loadingWheel.attr('hidden', true);
                    endPageHistory = true;
                    showErrorText(errorBox, errorTextObject, 'No data returned');
                }
            },
            error: function (xhr, status, error) {
                loadingWheel.attr('hidden', true);
                showErrorText(errorBox, errorTextObject, `Error code: ${xhr.status}`);
            }
        });
    }

    function doAjaxMain() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            url: `${url_main}?page=${pageNumMain}`,
            type: 'POST',
            success: function (data, status, xhr) {
                if(data.vehiclesMain[0] != null) {
                    hideErrorText(errorBox);
                    tableHistory.attr('hidden', true);
                    loadingWheel.attr('hidden', true);

                    $.each(data.vehiclesMain, function (i ,val) {
                        tableMainBody.append(
                            '<tr>' +
                            `<td>${val.license_plate}</td>` +
                            `<td>${val.vehicle_type}</td>` +
                            `<td>${val.arrival_time}</td>` +
                            `<td>` +
                            "<a href=" + url_details.replace(/.$/, `${val.car_id}`) + " class=\"btn btn-sm btn-info\">Details</a>" +
                            " <a href=" + url_update.replace(/.$/, `${val.car_id}`) + " class=\"btn btn-sm btn-warning mt-1 mt-md-0\">Update</a>" +
                            `</td>` +
                            '</tr>'
                        );
                    });
                } else {
                    loadingWheel.attr('hidden', true);
                    endPageMain = true;
                    showErrorText(errorBox, errorTextObject, 'No data returned');
                }
            },
            error: function (xhr, status, error) {
                loadingWheel.attr('hidden', true);
                showErrorText(errorBox, errorTextObject, `Error code: ${xhr.status}`);
            }
        });
    }

    function doSearchAjaxMain(text) {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            url: `${url_searchMain}`,
            type: "POST",
            data: {
                searchText: text,
            },
            success: function (data, status, xhr) {
                if(data.vehiclesMain[0] != null) {
                    $('.trMain').attr('hidden', true);
                    $('.trSearchMain').remove();
                    $.each(data.vehiclesMain, function (i ,val) {
                        tableMainBody.append(
                            '<tr class="trSearchMain">' +
                            `<td>${val.license_plate}</td>` +
                            `<td>${val.vehicle_type}</td>` +
                            `<td>${val.arrival_time}</td>` +
                            `<td>` +
                            "<a href=" + url_details.replace(/.$/, `${val.car_id}`) + " class=\"btn btn-sm btn-info\">Details</a>" +
                            " <a href=" + url_update.replace(/.$/, `${val.car_id}`) + " class=\"btn btn-sm btn-warning mt-1 mt-md-0\">Update</a>" +
                            `</td>` +
                            '</tr>'
                        );
                    });
                }
            }

        });
    }

    function doSearchAjaxHistory(text) {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            url: `${url_searchHistory}`,
            type: "POST",
            data: {
                searchText: text,
            },
            success: function (data, status, xhr) {
                if(data.vehiclesHistory[0] != null) {
                    $('.trHistory').attr('hidden', true);
                    $('.trSearchHistory').remove();
                    $.each(data.vehiclesHistory, function (i ,val) {
                        tableHistoryBody.append(
                            '<tr class="trSearchHistory">' +
                            `<td>${val.license_plate}</td>` +
                            `<td>${val.vehicle_type}</td>` +
                            `<td>${val.arrival_time}</td>` +
                            `<td>${val.departure_time}</td>` +
                            `<td>` +
                            "<a href=" + url_details.replace(/.$/, `${val.car_id}`) + " class=\"btn btn-sm btn-info\">Details</a>" +
                            `</td>` +
                            '</tr>'
                        );
                    });
                }
            }

        });
    }
});


