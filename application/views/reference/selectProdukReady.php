
<style>
  .select2-term-highlight {
    font-weight: bold;
    text-decoration: underline;
  }

  .select2-selection {
    height: auto !important;
  }
</style>
<script>
  $(document).ready(function() {
    $('#kode_produk').select2({
      placeholder: "Ketik kode atau nama produk. Contoh ( Netflix )",
      dropdownAutoWidth: true,
      ajax: {
        url: '<?= base_url('reference/refProduk/selectReady') ?>',
        dataType: 'json',
        delay: 250,
        data: function(params) {
          return {
            term: params.term
          };
        },
        processResults: function(data, params) {
          return {
            results: data.items.map(function(item) {
              var term = params.term;
              var text = item.text.replace(new RegExp('(' + term + ')', 'gi'), '<span class="select2-term-highlight">$1</span>');
              return {
                id: item.id,
                text: text,
                bisa_beli: item.bisa_beli
              };
            })
          };
        },
        cache: true
      },
      minimumInputLength: 3,
      escapeMarkup: function(markup) {
        return markup;
      },
      autofocus: true,
      dropdownAutoWidth: true,
      dropdownAutoHeight: true,
    });

    $(document).on('select2:open', e => {
      const select2 = $(e.target).data('select2');
      if (!select2.options.get('multiple')) {
        select2.dropdown.$search.get(0).focus();
      }
    });
  });
</script>