<div class="col-md-10 col-sm-10 col-md-offset-1">

                        <!-- Buttons -->
                        <ul class="nav nav-tabs-user mb-5-user" role="tablist">
                             <li class="active">
                                <a href="#new-sloshare" role="tab" data-toggle="tab" aria-expanded="false">
                                    <img src="{{ url('/icon-torrent.png') }}"> {{ __('sloshare.home-newsloshare-title') }}
                                </a>
                            </li>
                            <li class="">
                                <a href="#video" role="tab" data-toggle="tab" aria-expanded="true">
                                    <i class="{{ config('other.font-awesome') }} fa-film"></i> {{ __('sloshare.home-movie-title') }}
                                </a>
                            </li>
                             <li class="">
                                <a href="#tvseries" role="tab" data-toggle="tab" aria-expanded="true">
                                    <i class="{{ config('other.font-awesome') }} fa-tv-retro"></i> {{ __('sloshare.home-tvseries-title') }}
                                </a>
                            </li>
                             <li class="">
                                <a href="#games" role="tab" data-toggle="tab" aria-expanded="true">
                                    <i class="{{ config('other.font-awesome') }} fa-gamepad"></i> {{ __('sloshare.home-game-title') }}
                                </a>
                            </li>
                             <li class="">
                                <a href="#applications" role="tab" data-toggle="tab" aria-expanded="true">
                                    <i class="{{ config('other.font-awesome') }} fa-compact-disc"></i> {{ __('sloshare.home-applications-title') }}
                                </a>
                            </li>
                             <li class="">
                                <a href="#cartoons" role="tab" data-toggle="tab" aria-expanded="true">
                                    <i class="{{ config('other.font-awesome') }} fa-baby"></i> {{ __('sloshare.home-cartoons-title') }}
                                </a>
                            </li>
                             <li class="">
                                <a href="#xxx" role="tab" data-toggle="tab" aria-expanded="true">
                                    <i class="{{ config('other.font-awesome') }} fa-heart"></i> {{ __('sloshare.home-xxx-title') }}
                                </a>
                            </li>
                        </ul>
                        <!-- Buttons -->

    <div class="tab-pane fade active in" id="new-sloshare">


<div class="slideshow-container">

<div class="mySlides fade">
  <div class="numbertext">1 / 3</div>
  <img src="https://www.w3schools.com/howto/img_nature_wide.jpg" style="width:100%">
  <div class="text">Caption Text</div>
</div>

<div class="mySlides fade">
  <div class="numbertext">2 / 3</div>
  <img src="img_snow_wide.jpg" style="width:100%">
  <div class="text">Caption Two</div>
</div>

<div class="mySlides fade">
  <div class="numbertext">3 / 3</div>
  <img src="img_mountains_wide.jpg" style="width:100%">
  <div class="text">Caption Three</div>
</div>

<a class="prev" onclick="plusSlides(-1)">❮</a>
<a class="next" onclick="plusSlides(1)">❯</a>

</div>
<br>

<div style="text-align:center">
  <span class="dot" onclick="currentSlide(1)"></span>
  <span class="dot" onclick="currentSlide(2)"></span>
  <span class="dot" onclick="currentSlide(3)"></span>
</div>

<script>
let slideIndex = 1;
showSlides(slideIndex);

function plusSlides(n) {
  showSlides(slideIndex += n);
}

function currentSlide(n) {
  showSlides(slideIndex = n);
}

function showSlides(n) {
  let i;
  let slides = document.getElementsByClassName("mySlides");
  let dots = document.getElementsByClassName("dot");
  if (n > slides.length) {slideIndex = 1}
  if (n < 1) {slideIndex = slides.length}
  for (i = 0; i < slides.length; i++) {
    slides[i].style.display = "none";
  }
  for (i = 0; i < dots.length; i++) {
    dots[i].className = dots[i].className.replace(" active", "");
  }
  slides[slideIndex-1].style.display = "block";
  dots[slideIndex-1].className += " active";
}
</script>


    </div>
</div>
