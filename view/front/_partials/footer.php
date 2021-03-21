
</div>
</div>
</div>
</div>

<?php
// $message is only used for success messages, error messages are provided by GET method.
if(DB::hasMessage()) {
    $message = DB::getMessage();
    if($message['type'] === 'error') {
        $message['type'] = 'danger';
    } ?>

    <div class="alert alert-<?= $message['type'] ?> mx-auto fixed-top text-center w-75"><?= $message['message'] ?></div> <?php
} ?>

<script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.6.0/dist/umd/popper.min.js" integrity="sha384-KsvD1yqQ1/1+IA7gi3P0tyJcT3vR+NdBTt13hSJ2lnve8agRGXTTyNaBYmCR/Nwi" crossorigin="anonymous"></script>
<script src="//cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.5.1/main.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.5.1/locales-all.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.min.js" integrity="sha384-nsg8ua9HAw1y0W1btsyWgBklPnCUAFLuTMS2G72MMONqmOymq585AcH49TLBQObG" crossorigin="anonymous"></script>

<script src="/asset/js/app.js"></script>
<script src="/asset/js/forms.js"></script>
<script src="/asset/js/calendar.js"></script>
</body>

</html>