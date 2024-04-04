<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>

$(document).ready(function () {
    $('button').click(function () {
        alert('Botão clicado!');
    });

    $('#meuFormulario').submit(function (e) {
        e.preventDefault();

        var dadosFormulario = $(this).serialize();

        $.ajax({
            type: 'POST',
            url: 'meu_script.php',
            data: dadosFormulario,
            success: function (data) {
                $('#resultado').html(data);
            }
        });
    });
});
