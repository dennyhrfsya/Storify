window.addEventListener('load', function () {
    if (window.jQuery) {
        $(document).ready(function () {

            $('.select2-js').each(function () {
                $(this).select2({
                    placeholder: $(this).data('placeholder') || "Pilih Opsi...",
                    allowClear: true,
                    width: '100%',
                    dropdownAutoWidth: false,
                    minimumResultsForSearch: 0
                });
            });

            $(document).on('select2:open', function () {
                setTimeout(function () {
                    const searchField = document.querySelector(
                        '.select2-search__field');
                    if (searchField) searchField.focus();
                }, 50);
            });

            $(document).on('change', '.js-select-single', function () {
                const selectedValue = $(this).val();
                const $parent = $(this).closest('.dx-form-group');
                const $containerLainnya = $parent.find('.js-container-lainnya');
                const $inputLainnya = $parent.find('.js-input-lainnya');

                if (selectedValue === 'Lainnya') {
                    $containerLainnya.stop(true, true).fadeIn();
                    $inputLainnya.prop('required', true).focus();
                } else {
                    $containerLainnya.stop(true, true).fadeOut();
                    $inputLainnya.prop('required', false).val('');
                }
            });

            $('.js-select-single').each(function () {
                if ($(this).val() === 'Lainnya') {
                    $(this).closest('.dx-form-group').find('.js-container-lainnya').show();
                }
            });
        });
    }
});
