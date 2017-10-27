<?php $this->layout('view::Layout/layout.html.php'); ?>
Wir bieten Ihnen frische pflanzliche und fleischliche Produkte. Wählen Sie oben eine Kategorie.
<input type="hidden" value="<?= $this->v('success') ?>" data-id="success">
<script>
    $(function () {
        let success = $('input[type=hidden]');
        if (success == 'true') {
            notify({type: success, msg: 'Artikel erfolgreich bestellt'});
        }
    })
</script>