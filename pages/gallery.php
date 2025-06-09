<h1>Gallery Page</h1>

<?php
Messages::getMessage();
?>

<!-- Форма загрузки -->
<form action="index.php" method="post" enctype="multipart/form-data">
    <div class="form-group">
        <label for="image">Image: </label>
        <input type="file" name="image" class="form-control">
    </div>
    <button class="btn btn-primary mt-3" name="action" value="uploadImage">Upload</button>
</form>

<hr>

<!-- Слайдер изображений -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css"/>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.css"/>

<div class="image-slider mt-5">
    <?php
    
    $images = glob('uploads/*.{jpg,jpeg,png,gif}', GLOB_BRACE);
    $images = array_slice($images, 0, 5); // берём только первые 5
    
    foreach ($images as $img) {
        echo "<a href='$img' data-fancybox='gallery'><img src='$img' style='height: 150px; margin-right: 10px;'></a>";
    }
    ?>
</div>

<!-- JS -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.umd.js"></script>

<script>
    $(document).ready(function(){
        $('.image-slider').slick({
            slidesToShow: 3,
            slidesToScroll: 1,
            arrows: true,
            infinite: false
        });
    });
</script>
