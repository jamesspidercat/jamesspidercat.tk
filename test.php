<?php
//page_top.php var setup
$page_title = "thispage | Sam's Books";
$curPage  = "thispage";
$require_login = '0';
$jsPaths = array('js/main.js');
require_once('page_top.php');
?>
<div class="container" style="color: white;">
    <div class="row justify-content-between"><!-- start between end center (if only 1 in middle)-->
        <div class="col-4">
            Irure do cillum dolore adipisicing in. Eu excepteur duis commodo tempor aliqua aliqua commodo nostrud et ex ex esse. Elit Lorem incididunt occaecat non in velit reprehenderit proident. In deserunt quis consequat eiusmod ad exercitation commodo. Aute do cillum magna sunt. Ipsum ut incididunt reprehenderit dolore ad quis qui reprehenderit.
        </div>
        <div class="col-4">
            <figure class="figure">
                <img class="figure-img" src="blog/1/cat.jpg" width="70%">
                <figcaption class="figure-caption text-white">A caption for the above image.</figcaption>
            </figure>
        </div>
    </div>
    <div class="row">
        <div class="col-8">
            Et velit culpa cillum ad adipisicing Lorem est voluptate qui excepteur elit reprehenderit. Occaecat mollit irure culpa duis et. Duis proident dolore dolor proident esse. Ad anim tempor cillum cillum enim et eu. Nisi veniam anim ad ullamco in sint sint officia ullamco non minim. Esse eiusmod proident in deserunt. Voluptate minim ullamco ex cillum.

Do sunt labore tempor aliqua enim et. Nulla culpa aute ipsum do. Esse aute culpa sunt culpa veniam est culpa veniam consectetur laborum eiusmod reprehenderit.

Et mollit incididunt voluptate sit. Ex sint est aliqua excepteur incididunt dolor minim esse consectetur pariatur incididunt et. Magna qui fugiat excepteur dolor amet quis laborum irure pariatur. Sit nostrud sit in quis magna magna incididunt fugiat proident dolor commodo laboris.

Minim aliqua nisi fugiat proident ea et. Aliqua laboris duis sint commodo laboris fugiat magna consectetur ut. Aliqua duis adipisicing enim mollit consequat id veniam. Dolore consectetur esse commodo in voluptate.

Anim elit deserunt cillum mollit eiusmod magna est aliquip. Ad dolor duis aliquip cillum pariatur. Velit tempor dolor deserunt fugiat voluptate sunt sint incididunt ad. Velit culpa ad eu aute dolore occaecat anim dolor et veniam qui.
        </div>
        <div class="col-4">
            <figure class="figure">
                <video class="figure-img" src="blog/1/sample-mp4-file.mp4" controls width="100%"></video>
                <figcaption class="figure-caption text-white">Wow a video</figcaption>
            </figure>
        </div>
    </div>
    <div class="row justify-content-center">
        <div class="col-4">
            <figure class="figure">
                <audio class="figure-img" src="blog/1/file_example_MP3_700KB.mp3" controls></audio>
                <figcaption class="figure-caption text-white">Wow an audio</figcaption>
            </figure>
        </div>
    </div>
</div>
<?php
include ("page_bottom.php");
?>