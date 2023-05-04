<main>
    <h3 class="text-center">Review MSH</h3>
    <p class="text-center">Silahkan diisi form berikut ini</p>
    <?php $validation = \Config\Services::validation(); ?>
    <form action="<?= site_url('msh/save') ?>" method="POST" id="reviewForm" onsubmit="onSubmit(event)">
        <?= csrf_field(); ?>
        <!-- Recaptcha Error -->
        <?php if( $validation->getError('recaptcha_response') ) {?>
        <div class="alert alert-danger">
            <?= $validation->getError('recaptcha_response'); ?>
        </div>
        <?php }?>
        <div class="mb-3">
            <label for="nama" class="form-label">Nama</label>
            <input type="text" class="form-control" id="nama" maxlength="100" name="nama">
        </div>
        <div class="mb-3">
            <label for="url" class="form-label">url</label>
            <input type="text" class="form-control" id="url" maxlength="100" name="url">
        </div>
        <div class="mb-3">
            <label for="review" class="form-label">Review</label>
            <textarea class="form-control" id="review" name="review" rows="3"></textarea>
        </div>
        <div class="mb-3">
            <label for="review" class="form-label">Screenshot</label>
            <input type="file" class="form-control" id="picture" name="picture">
        </div>
        <div class="mb-3">
            <button type="submit" class="btn btn-primary"><i class="bi bi-save"></i> Simpan</button>
        </div>
    </form>
</main>

<script type="text/javascript">
    function onSubmit(e) {
        e.preventDefault();
        grecaptcha.ready(function() {
            grecaptcha.execute("<?= getenv('GOOGLE_RECAPTCHAV3_SITEKEY') ?>", {
                action: 'submit'
            }).then(function(token) {

                // Store recaptcha response
                document.getElementById("recaptcha_response").value = token;

                // Submit form
                document.getElementById("reviewForm").submit();

            });
        });
    }
</script>