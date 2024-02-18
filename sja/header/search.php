<div id='zoekveld'>

<form role="search" method="get" class="search-form" action="<?=SITE_URI?>">
    <label>
        <span class="screen-reader-text"><?=\agitatie\taal\streng('Zoeken naar')?>:</span>
        <input class="search-field" placeholder="<?=\agitatie\taal\streng('Zoeken')?> …" value="" name="s" type="search">
    </label>
    <label for='kop-zoekveld'>
        <input id='kop-zoekveld' class="search-submit" value="<?=\agitatie\taal\streng('Zoeken')?>" type="submit">
        <i class='mdi mdi-arrow-right-thick'></i>
    </label>
</form>

</div>