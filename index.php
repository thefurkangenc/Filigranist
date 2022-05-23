<?php
include 'header.php';
?>
<div class=" container">
    <form action="" id="imageData" method="POST" enctype="multipart/form-data">
        <div class="row">
            <div class="col-md-6 mt-5 mb-5">
                <div class="badge text-dark">Görseller / Images</div>
                <input required="" class="form-control" type="file" name="image[]" id="image" multiple accept=".jpg">
            </div>
            <div class="col-md-6  mt-5 mb-5">
                <div class="badge text-dark">Filigran / Watermark</div>
                <input type="file" required class="form-control" name="watermark" accept=".png">
            </div>
        </div>
        <button name="submit" type="submit" class="btn submitBtn container-fluid" id="submitBtn">
            Generate
        </button>
        <div style="display: none;" id="alert" class="alert alert-secondary" align="center">İşleniyor...</div>
    </form>
    <div class="container">
        <div class="row" id="imagesContainer">

        </div>
    </div>
</div>

<?php
include 'footer.php';
?>





<script>
 
</script>