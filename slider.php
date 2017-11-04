<!-- Start Slider ////////////////////////////////////// -->

    <script type="text/javascript" src="slider/jssor.slider.min.js"></script>

    <script>
        jQuery(document).ready(function ($) {

            var options = {
                $SlideDuration: 800,                    //[Optional] Specifies default duration (swipe) for slide in milliseconds, default value is 500
                $DragOrientation: 3,                    //[Optional] Orientation to drag slide, 0 no drag, 1 horizental, 2 vertical, 3 either, default value is 1 (Note that the $DragOrientation should be the same as $PlayOrientation when $Cols is greater than 1, or parking position is not 0)
                $AutoPlay: 1,                           //[Optional] Auto play or not, to enable slideshow, this option must be set to greater than 0. Default value is 0. 0: no auto play, 1: continuously, 2: stop at last slide, 4: stop on click, 8: stop on user navigation (by arrow/bullet/thumbnail/drag/arrow key navigation)
                $Idle: 1500,                            //[Optional] Interval (in milliseconds) to go for next slide since the previous stopped if the slider is auto playing, default value is 3000

                $BulletNavigatorOptions: {              //[Optional] Options to specify and enable navigator or not
                    $Class: $JssorBulletNavigator$,     //[Required] Class to create navigator instance
                    $ChanceToShow: 2,                   //[Required] 0 Never, 1 Mouse Over, 2 Always
                    $Steps: 1,                          //[Optional] Steps to go for each navigation request, default value is 1
                    $Rows: 1,                           //[Optional] Specify lanes to arrange items, default value is 1
                    $SpacingX: 10,                      //[Optional] Horizontal space between each item in pixel, default value is 0
                    $SpacingY: 10,                      //[Optional] Vertical space between each item in pixel, default value is 0
                    $Orientation: 1                     //[Optional] The orientation of the navigator, 1 horizontal, 2 vertical, default value is 1
                },

                $ArrowNavigatorOptions: {
                    $Class: $JssorArrowNavigator$,      //[Requried] Class to create arrow navigator instance
                    $ChanceToShow: 2                    //[Required] 0 Never, 1 Mouse Over, 2 Always
                }
            };

            var jssor_slider1 = new $JssorSlider$("slider1_container", options);
            //make sure to clear margin of the slider container element
            jssor_slider1.$Elmt.style.margin = "";

            //#region responsive code begin
            //the following code is to place slider in the center of parent container with no scale
            function ScaleSlider() {

                var containerElement = jssor_slider1.$Elmt.parentNode;
                var containerWidth = containerElement.clientWidth;

                if (containerWidth) {
                    var expectedWidth = Math.min(containerWidth, jssor_slider1.$OriginalWidth());

                    //scale the slider to original height with no change
                    jssor_slider1.$ScaleSize(expectedWidth, jssor_slider1.$OriginalHeight());

                    jssor_slider1.$Elmt.style.left = ((containerWidth - expectedWidth) / 2) + "px";
                }
                else {
                    window.setTimeout(ScaleSlider, 30);
                }
            }

            ScaleSlider();

            $(window).bind("load", ScaleSlider);
            $(window).bind("resize", ScaleSlider);
            $(window).bind("orientationchange", ScaleSlider);
            //#endregion responsive code end
        });
    </script>
    
    <!-- make a div with 100% width, place jssor slider in the div -->
    <div style="position:relative;top:0;left:0;width:100%;overflow:hidden;background:#80bfff;padding-bottom:8px;padding-top:8px;border-bottom: 2px solid #0000cc;">

        <!--#region Jssor Slider Begin -->
        <div id="slider1_container" style="position: relative; margin: 0 auto; top: 0px; left: 0px; width: 980px; height: 380px;">
            <!-- Loading Screen -->
            <div data-u="loading" class="jssorl-009-spin" style="position:absolute;top:0px;left:0px;width:100%;height:100%;text-align:center;background-color:rgba(0,0,0,0.7);">
                <img style="margin-top:-19px;position:relative;top:50%;width:38px;height:38px;" src="../svg/loading/static-svg/spin.svg" />
            </div>

            <!-- Slides Container -->
            <div u="slides" style="cursor: move; position: absolute; left: 0px; top: 0px; width: 980px;  height: 380px; overflow: hidden;">
                <div>
					<a href="Baza_date_Cablu.php">
						<img data-u="image" src="poze/cablu.jpg" />
					</a>
                </div>
                <div> 
					<a href="Baza_date_Telefon.php">
						<img data-u="image" src="poze/telefon.jpg" />
					</a>
                </div>
                <div>
					<a href="Baza_date_Internet.php">
						<img data-u="image" src="poze/internet.jpg" />
					</a>
                </div>
            </div>
            
            <!--#region Bullet Navigator Skin Begin -->
            <!-- Help: https://www.jssor.com/development/slider-with-bullet-navigator.html -->
            <style>
                .jssorb051 .i {position:absolute;cursor:pointer;}
                .jssorb051 .i .b {fill:#fff;fill-opacity:0.5;stroke:#000;stroke-width:400;stroke-miterlimit:10;stroke-opacity:0.5;}
                .jssorb051 .i:hover .b {fill-opacity:.7;}
                .jssorb051 .iav .b {fill-opacity: 1;}
                .jssorb051 .i.idn {opacity:.3;}
            </style>
            <div data-u="navigator" class="jssorb051" style="position:absolute;bottom:12px;right:12px;" data-autocenter="1" data-scale="0.5" data-scale-bottom="0.75">
                <div data-u="prototype" class="i" style="width:16px;height:16px;">
                    <svg viewBox="0 0 16000 16000" style="position:absolute;top:0;left:0;width:100%;height:100%;">
                        <circle class="b" cx="8000" cy="8000" r="5800"></circle>
                    </svg>
                </div>
            </div>
            <!--#endregion Bullet Navigator Skin End -->
        
            <!--#region Arrow Navigator Skin Begin -->
            <!-- Help: https://www.jssor.com/development/slider-with-arrow-navigator.html -->
            <style>
                .jssora051 {display:block;position:absolute;cursor:pointer;}
                .jssora051 .a {fill:none;stroke:#fff;stroke-width:360;stroke-miterlimit:10;}
                .jssora051:hover {opacity:.8;}
                .jssora051.jssora051dn {opacity:.5;}
                .jssora051.jssora051ds {opacity:.3;pointer-events:none;}
            </style>
            <div data-u="arrowleft" class="jssora051" style="width:55px;height:55px;top:0px;left:25px;" data-autocenter="2" data-scale="0.75" data-scale-left="0.75">
                <svg viewBox="0 0 16000 16000" style="position:absolute;top:0;left:0;width:100%;height:100%;">
                    <polyline class="a" points="11040,1920 4960,8000 11040,14080 "></polyline>
                </svg>
            </div>
            <div data-u="arrowright" class="jssora051" style="width:55px;height:55px;top:0px;right:25px;" data-autocenter="2" data-scale="0.75" data-scale-right="0.75">
                <svg viewBox="0 0 16000 16000" style="position:absolute;top:0;left:0;width:100%;height:100%;">
                    <polyline class="a" points="4960,1920 11040,8000 4960,14080 "></polyline>
                </svg>
            </div>
            <!--#endregion Arrow Navigator Skin End -->

        </div>
        <!--#endregion Jssor Slider End -->
    </div>

	
<!-- End Slider //////////////////////////////////////  -->