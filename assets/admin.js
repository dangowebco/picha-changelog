jQuery(document).ready(function ($) {
    jalaliDatepicker.startWatch({
        minDate: "attr",
        maxDate: "attr",
        zIndex: 99999,
        time: false,
        separatorChars: {
            between: ' - '
        }
    });
    $(document).on('click', '.dwp-bulk-add-items', function (e) {
        const $this = $(this);
        const items = $(this).parents('.dwp-body:first').find('.dwp-area-items').val().split('\n');
        const index = $(this).data('index');
        $.each(items, function (key, value) {
            const itemIndex = $this.parents('.dwp-box:first').find('.dwp-body-row').length;
            console.log(itemIndex);
            const fields = $('<li class="dwp-body-row"><div><select name="dwp[' + index + '][item][' + itemIndex + '][status]">' +
                '<option value="added">' + dwp.added + '</option>' +
                '<option value="fixed">' + dwp.fixed + '</option>' +
                '<option value="updated">' + dwp.updated + '</option>' +
                '<option value="improved">' + dwp.improved + '</option>' +
                '<option value="removed">' + dwp.removed + '</option>' +
                '<option value="deprecated">' + dwp.deprecated + '</option>' +
                '<option value="compatibility">' + dwp.compatibility + '</option>' +
                '<option value="special">' + dwp.special + '</option>' +
                '</select></div><div class="dwp-row-log"><input type="text" name="dwp[' + index + '][item][' + itemIndex + '][content]" value="' + value + '"></div><div class="dw-delete-row  dashicons dashicons-trash"></div></li>');
            $this.parents('.dwp-box:first').find('#dwp-body-area').append(fields);
        });
    });
    $(document).on('click', '.dwp-add-bulk-log', function (e) {
        $(this).parents('.dwp-body:first').find('.dwp-bulk-area-wrapper').slideToggle();
    })
    $(document).on('click', '.dw-add-new', function (e) {
        e.preventDefault();
        const index = $('#dwp-box-list').find('.dwp-box').length;
        const section = '<div class="dwp-box">' +
            '<div class="dwp-header">' +
            '<div class="dwp-info">' +
            '<div><div>' +
            '<label>' + dwp.version + '<input type="text" name="dwp[' + index + '][version]"></label>' +
            '</div>' +
            '<div><label>' + dwp.jalaliDate + '<input type="text"  name="dwp[' + index + '][jalali_date]" data-jdp data-jdp-only-date></label></div>' +
            '<div><label>' + dwp.gregorianDate + '<input type="date" name="dwp[' + index + '][gregorian_date]"></label></div>' +
            '</div>' +
            '<div class="dw-delete-section">' + dwp.delete + '</div>' +
            '</div>' +
            '</div>' +
            '<div class="dwp-body">' +
            '<div class="dwp-add-log" data-index="' + index + '">' + dwp.add + '</div>' +
            ' <div class="dwp-add-bulk-log" data-index="<?php echo $index ?>">' + dwp.addBulk + '</div>' +
            '<div class="dwp-bulk-area-wrapper">' +
            '<div>' + dwp.bulkDesc + '</div>' +
            '<textarea class="dwp-area-items" rows="10"></textarea>' +
            '<span class="dwp-bulk-add-items" data-index="' + index + '">' + dwp.add + '</span>' +
            '</div>' +
            '<div class="dwp_description"><label>' + dwp.description + '<textarea  name="dwp[' + index + '][description]" ></textarea></label></div>' +
            '<ul id="dwp-body-area"></ul>' +
            '</div>' +
            '<div class="dwp-footer">' +
            '</div>' +
            '</div>';
        $('#dwp-box-list').prepend(section);
    });
    $(document).on('click', '.dwp-add-log', function (e) {
        e.preventDefault();
        const index = $(this).data('index');
        const itemIndex = $(this).parents('.dwp-box:first').find('.dwp-body-row').length;
        const fields = $('<li class="dwp-body-row"><div><select name="dwp[' + index + '][item][' + itemIndex + '][status]">' +
            '<option value="added">' + dwp.added + '</option>' +
            '<option value="fixed">' + dwp.fixed + '</option>' +
            '<option value="updated">' + dwp.updated + '</option>' +
            '<option value="improved">' + dwp.improved + '</option>' +
            '<option value="removed">' + dwp.removed + '</option>' +
            '<option value="deprecated">' + dwp.deprecated + '</option>' +
            '<option value="compatibility">' + dwp.compatibility + '</option>' +
            '<option value="special">' + dwp.special + '</option>' +
            '</select></div><div class="dwp-row-log"><input type="text" name="dwp[' + index + '][item][' + itemIndex + '][content]"></div><div class="dw-delete-row  dashicons dashicons-trash"></div></li>');
        $(this).parents('.dwp-box:first').find('#dwp-body-area').append(fields);
    });
    $(document).on('click', '.dw-delete-row', function (e) {
        e.preventDefault();
        $(this).parents('.dwp-body-row').remove()
    });
    $(document).on('click', '.dw-delete-section', function (e) {
        e.preventDefault();
        $(this).parents('.dwp-box').remove()
    });
    $(function () {
        $(document).on('click', '.dwp_shortcode', function () {
            this.select();
        });
    });
})