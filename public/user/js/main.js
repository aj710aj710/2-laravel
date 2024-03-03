(function ($) {
    "use strict";

    var Medi = {
      init: function () {
        this.Basic.init();
      },

      Basic: {
        init: function () {
          this.Preloader();
          this.StickyHeader();
          this.Tools();
          this.BackgroundImage();
          this.MobileMenu();
          this.Select();
          this.Editor();
          this.DateRangePicker();
          // this.Z_Chart();
          this.MultiForm();
          this.Ld_Testimonial();
        },
        Preloader: function () {
          $("#preloader-status").fadeOut();
          $("#preloader").delay(350).fadeOut("slow");
          $("body").delay(350);
        },
        StickyHeader: function () {
          $(window).on("scroll", function () {
            var scroll = $(window).scrollTop();
            if (scroll < 100) {
              $(".landing-header").removeClass("sticky");
            } else {
              $(".landing-header").addClass("sticky");
            }
          });
        },
        Tools: function () {
          // Add calendar icon
          $("input.date-icon").each(function () {
            $(this).closest(".zForm-wrap").addClass("calendarIcon"); // Add your custom class here
          });

          // Show/Hide Add plan inner field
          $(".bilingCycle-checkbox-item").click(function () {
            var index = $(this).index();
            var hideItems = $(".bilingCycle-open-items .bilingCycle-open-item");

            if (hideItems.length === 2) {
              hideItems
                .eq(index - 1)
                .removeClass("d-none")
                .addClass("d-block");
            }

            hideItems.each(function (i, el) {
              if (i !== index - 1 && $(el).hasClass("d-block")) {
                $(el).removeClass("d-block").addClass("d-none");
              }
            });
          });

          // Checkout page payment
          $(document).ready(function () {
            $(".checkoutPaymentItem li button").click(function () {
              $(".checkoutPaymentItem li button").removeClass("active");
              $(this).addClass("active");
            });
          });

          // Landing page price toggle
          $("#zPrice-plan-switch").on("click", function () {
            $(".zPrice-plan-monthly").toggleClass("d-none");
            $(".zPrice-plan-yearly").toggleClass("d-block");
          });
        },
        BackgroundImage: function () {
          $("[data-background]").each(function () {
            $(this).css("background-image", "url(" + $(this).attr("data-background") + ")");
          });
        },
        MobileMenu: function () {
          $(".mobileMenu").on("click", function () {
            $(".zSidebar").addClass("menuClose");
          });
          $(".zSidebar-overlay").on("click", function () {
            $(".zSidebar").removeClass("menuClose");
          });
          // Menu arrow
          $(".zSidebar-menu li a").each(function () {
            if ($(this).next("div").find("ul.sub-menu li").length > 0) {
              $(this).addClass("has-subMenu-arrow");
            }
          });
        },
        Select: function () {
          // when need select with search field
          $(".sf-select").select2({
            dropdownCssClass: "sf-select-dropdown",
            selectionCssClass: "sf-select-section",
            // minimumResultsForSearch: -1,
          });
          // when don't need search field but can't use in modal
          $(".sf-select-two").select2({
            dropdownCssClass: "sf-select-dropdown",
            selectionCssClass: "sf-select-section",
            minimumResultsForSearch: -1,
          });
          // when don't need search field and can use in modal
          $(".sf-select-without-search").niceSelect();
          // when need search in modal
          $(".sf-select-modal").select2({
            dropdownCssClass: "sf-select-dropdown",
            selectionCssClass: "sf-select-section",
            dropdownParent: $(".modal"),
          });
        },
        Editor: function () {
          $(".summernoteOne").summernote({
            placeholder: "Write description...",
            tabsize: 2,
            minHeight: 183,
            toolbar: [
              // ["style", ["style"]],
              // ["view", ["undo", "redo"]],
              // ["fontname", ["fontname"]],
              // ["fontsize", ["fontsize"]],
              // ["font", ["bold", "italic", "underline"]],
              // ["para", ["ul", "ol", "paragraph"]],
              // ["color", ["color"]],
              ["font", ["bold", "italic", "underline"]],
              ["para", ["ul", "ol", "paragraph"]],
            ],
          });
        },
        DateRangePicker: function () {
          $(".date-time-picker").daterangepicker({
            singleDatePicker: true,
            timePicker: false,
            autoApply: true,
            opens: "left",
            // drops: "up",
            locale: {
              format: "Y/M/D",
            },
          });
          $(".date-time-picker-right").daterangepicker({
            singleDatePicker: true,
            timePicker: false,
            autoApply: true,
            opens: "right",
            locale: {
              format: "Y/M/D",
            },
          });
          $(".date-time-picker-right-up").daterangepicker({
            singleDatePicker: true,
            timePicker: false,
            autoApply: true,
            opens: "right",
            drops: "up",
            locale: {
              format: "Y/M/D",
            },
          });
          $(".date-time-picker-left-up").daterangepicker({
            singleDatePicker: true,
            timePicker: false,
            autoApply: true,
            opens: "left",
            drops: "up",
            locale: {
              format: "Y/M/D",
            },
          });
        },
        Z_Chart: function () {
          var options = {
            series: [
              {
                name: "",
                data: [1500, 550, 1750, 1000, 1000, 1000, 2250, 450, 450, 1200, 1200, 2750],
              },
            ],
            chart: {
              type: "bar",
              height: 350,
              toolbar: {
                show: false,
              },
            },
            plotOptions: {
              bar: {
                borderRadius: 7,
                horizontal: false,
              },
            },
            dataLabels: {
              enabled: false,
            },
            stroke: {
              show: true,
              width: 2,
            },
            states: {
              hover: {
                filter: {
                  type: "none",
                  value: 0.1,
                },
              },
            },
            xaxis: {
              categories: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
              axisTicks: {
                show: false,
              },
            },
            yaxis: {
              tickAmount: 4,
              // min: 0,
              // max: 3000,
              crosshairs: {
                show: true,
                position: "back",
                stroke: {
                  color: "#000000",
                },
              },
            },
            fill: {
              opacity: 1,
            },
            colors: ["#7F56D9", "#ff0000"],
            legend: {
              show: false,
            },
          };

          var zActivityChart = new ApexCharts(document.querySelector("#activityChart"), options);
          zActivityChart.render();

          var options = {
            // series: [
            //   {
            //     name: "South",
            //     data: [1500, 550, 1750, 1000, 1000, 1000, 2250, 450, 450, 1200, 1200, 2750],
            //   },
            // ],
            // chart: {
            //   type: "area",
            //   height: 350,
            //   stacked: true,
            //   toolbar: {
            //     show: false,
            //   },
            //   events: {
            //     selection: function (chart, e) {
            //       console.log(new Date(e.xaxis.min));
            //     },
            //   },
            // },
            // colors: ["#008FFB", "#00E396", "#CED4DC"],
            // dataLabels: {
            //   enabled: false,
            // },
            // stroke: {
            //   curve: "smooth",
            // },
            // fill: {
            //   type: "gradient",
            //   gradient: {
            //     opacityFrom: 0.6,
            //     opacityTo: 0.8,
            //   },
            // },
            // legend: {
            //   position: "top",
            //   horizontalAlign: "left",
            // },
            // xaxis: {
            //   type: "datetime",
            // },

            chart: {
              height: 350,
              type: "area",
              toolbar: {
                show: false,
              },
            },
            colors: ["#7F56D9"],
            dataLabels: {
              enabled: false,
            },
            series: [
              {
                name: "Series 1",
                data: [4000, 550, 1000, 350, 2000, 900, 1600],
              },
            ],
            fill: {
              type: "gradient",
              gradient: {
                gradientToColors: ["#7F56D9"],
                shadeIntensity: 1,
                type: "vertical",
                opacityFrom: 1,
                opacityTo: 0.5,
                stops: [0, 100],
              },
            },
            xaxis: {
              categories: ["MON", "TUE", "WED", "THU", "FRI", "SAT", "SUN"],
              axisTicks: {
                show: false,
              },
              labels: {
                style: {
                  // colors: [],
                  // fontSize: '12px',
                  // fontFamily: 'Helvetica, Arial, sans-serif',
                  // fontWeight: 400,
                  cssClass: "apexcharts-yaxis-label",
                },
              },
            },
            yaxis: {
              tickAmount: 4,
              min: 0,
              max: 4000,
            },
          };

          var z_activeUserChart = new ApexCharts(document.querySelector("#activeUserChart"), options);
          z_activeUserChart.render();
        },
        MultiForm: function () {
          var current_fs, next_fs, previous_fs; //fieldsets
          var opacity;
          var current = 1;
          var steps = $("fieldset").length;

          setProgressBar(current);

          $(".next").click(function () {
            current_fs = $(this).parent();
            next_fs = $(this).parent().next();

            //Add Class Active
            $("#progressbar li").eq($("fieldset").index(next_fs)).addClass("active");

            //show the next fieldset
            next_fs.show();
            //hide the current fieldset with style
            current_fs.animate(
              { opacity: 0 },
              {
                step: function (now) {
                  // for making fielset appear animation
                  opacity = 1 - now;

                  current_fs.css({
                    display: "none",
                    position: "relative",
                  });
                  next_fs.css({ opacity: opacity });
                },
                duration: 500,
              }
            );
            setProgressBar(++current);
          });

          $(".previous").click(function () {
            current_fs = $(this).parent();
            previous_fs = $(this).parent().prev();

            //Remove class active
            $("#progressbar li").eq($("fieldset").index(current_fs)).removeClass("active");

            //show the previous fieldset
            previous_fs.show();

            //hide the current fieldset with style
            current_fs.animate(
              { opacity: 0 },
              {
                step: function (now) {
                  // for making fielset appear animation
                  opacity = 1 - now;

                  current_fs.css({
                    display: "none",
                    position: "relative",
                  });
                  previous_fs.css({ opacity: opacity });
                },
                duration: 500,
              }
            );
            // setProgressBar(--current);
          });

          function setProgressBar(curStep) {
            var percent = parseFloat(100 / steps) * curStep;
            percent = percent.toFixed();
            $(".progress-bar").css("width", percent + "%");
          }

          // $(".submit").click(function () {
          //   return false;
          // });
        },
        Ld_Testimonial: function () {
          var swiper = new Swiper(".testiSlider", {
            slidesPerView: 1,
            spaceBetween: 10,
            navigation: {
              nextEl: ".swiper-button-next",
              prevEl: ".swiper-button-prev",
            },
            breakpoints: {
              1400: {
                slidesPerView: 2,
                spaceBetween: 30,
              },
            },
          });
        },
      },
    };
    jQuery(document).ready(function () {
      Medi.init();
    });
  })(jQuery);
