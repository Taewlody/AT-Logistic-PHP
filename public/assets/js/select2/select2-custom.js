"use strict";
setTimeout(function(){
        (function($) {
            // "use strict";

            // $(".select2-single").on('change', function (e) {
            //     console.log('change select', e);
            //     // @this.set('value', e.target.value);
            // });
            // Single Search Select
            $(".select2-single").not('.select2-search').select2({
                minimumResultsForSearch: Infinity
            });
            $(".select2-single.select2-search").select2();
            
            $(".select2_multiple.select2_search").select2({});
            
            
            // $(".js-example-disabled-results").select2();

            // Multi Select
            // $(".js-example-basic-multiple").select2();

            // With Placeholder
            // $(".js-example-placeholder-multiple").select2({
            //     placeholder: "Select Your Name"
            // });

            //Limited Numbers
            // $(".js-example-basic-multiple-limit").select2({
            //     maximumSelectionLength: 2
            // });

            //RTL Suppoort
            // $(".js-example-rtl").select2({
            //     dir: "rtl"
            // });
            // Responsive width Search Select
            // $(".js-example-basic-hide-search").select2({
            //     minimumResultsForSearch: Infinity
            // });
            // $(".js-example-disabled").select2({
            //     disabled: true
            // });
            // $(".js-programmatic-enable").on("click", function() {
            //     $(".js-example-disabled").prop("disabled", false);
            // });
            // $(".js-programmatic-disable").on("click", function() {
            //     $(".js-example-disabled").prop("disabled", true);
            // });
        })(jQuery);
    }
    // ,350);
    , 50);