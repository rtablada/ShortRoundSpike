@section('styles')
<link rel="stylesheet" href="/css/medium-editor.css"/>
<link rel="stylesheet" href="/css/medium-bootstrap.css"/>
@append

@section('scripts')
<script src="/js/medium-editor.js"></script>
<script>
    (function() {
        var editor = new MediumEditor('.editable', {
                buttonLabels: 'fontawesome'
            });

        $('form').on('submit', function() {
            $('.editable').each(function (mediumEditor) {
                var field = this.dataset.field;

                $("[name='" + field + "']").val(this.innerHTML);
            });
        })
    })();
</script>
@append
