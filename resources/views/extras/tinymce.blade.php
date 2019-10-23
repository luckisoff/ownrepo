{{--<script src="{{asset('public/plugins/tinymce/tinymce.min.js')}}"></script>--}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/tinymce/4.7.6/tinymce.min.js"></script>

<script>
  $(document).ready(function () {
    tinymceSimpleInit();

    tinymce.init({
      selector: 'textarea.asdh-tinymce',
      menu    : {
        file  : {title: 'File', items: 'newdocument'},
        insert: {title: 'Insert', items: 'link media image | template'},
        view  : {title: 'View', items: 'visualaid'},
        format: {
          title: 'Format',
          items: 'bold italic underline strikethrough superscript subscript | formats | removeformat'
        },
        table : {title: 'Table', items: 'inserttable tableprops deletetable | cell row column'},
        tools : {title: 'Tools', items: 'spellchecker code'}
      },
      plugins : "link image advlist lists charmap print preview anchor autosave code codesample textcolor colorpicker table searchreplace media print hr preview",
      toolbar : [
        'bold italic underline | alignleft aligncenter alignright alignjustify | bullist numlist link unlink charmap code', // image media indent outdent
        'formatselect fontselect fontsizeselect | forecolor backcolor'
      ]
    });
  });
</script>

<script>
  function tinymceSimpleInit() {
    tinymce.init({
      selector: 'textarea.asdh-tinymce.basic',
      // height: 500,
      menubar: false,
      plugins: [
        'advlist autolink lists link image charmap print preview anchor textcolor',
        'searchreplace visualblocks code fullscreen',
        'insertdatetime media table paste code help wordcount'
      ],
      toolbar: 'bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | removeformat | help'
    });
  }
</script>