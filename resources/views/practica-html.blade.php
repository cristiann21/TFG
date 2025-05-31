@extends('layouts.app')
@section('content')
<div class="practica-html-main">
    <div class="practica-html-left">
        <h2>Escribe tu código HTML</h2>
        <textarea id="html-input"></textarea>
    </div>
    <div class="practica-html-right">
        <h2>Resultado</h2>
        <iframe id="html-preview"></iframe>
    </div>
</div>
@push('styles')
<style>
.practica-html-main {
    display: flex;
    min-height: 70vh;
    width: 100vw;
    background: #e3f6e3;
    padding: 40px 0 40px 0;
    gap: 0;
}
.practica-html-left, .practica-html-right {
    flex: 1;
    display: flex;
    flex-direction: column;
    align-items: center;
    padding: 24px 12px;
    min-width: 0;
}
.practica-html-left h2, .practica-html-right h2 {
    font-size: 1.5rem;
    margin-bottom: 18px;
    font-weight: bold;
    color: #23242a;
}
#html-input {
    width: 95%;
    height: 60vh;
    min-height: 260px;
    border-radius: 10px;
    border: 2px solid #b2d8b2;
    font-size: 16px;
    font-family: 'Fira Mono', 'Consolas', monospace;
    padding: 16px;
    background: #f2f3f4;
    resize: none;
    box-shadow: 0 2px 8px #0001;
}
#html-preview {
    width: 95%;
    height: 60vh;
    min-height: 260px;
    border-radius: 10px;
    border: 2px solid #b2d8b2;
    background: #fff;
    box-shadow: 0 2px 8px #0001;
}
@media (max-width: 900px) {
    .practica-html-main {
        flex-direction: column;
        gap: 24px;
    }
    #html-input, #html-preview {
        width: 98vw;
        min-width: unset;
        max-width: unset;
    }
}
</style>
@endpush
<script>
const htmlInput = document.getElementById("html-input");
const htmlPreview = document.getElementById("html-preview");

htmlInput.addEventListener("input", (e) => {
    let texto = htmlInput.value;

    // Detecta si el usuario acaba de escribir '>' después de un '<tag>'
    const ultimaParte = texto.slice(-1);
    if (ultimaParte === '>') {
        const regexUltima = /<(\w+)(?:\s[^<>]*)?>$/;
        const match = texto.match(regexUltima);
        if (match) {
            const tag = match[1];
            const autocontenidos = ['img', 'br', 'input', 'hr', 'meta', 'link'];
            if (!autocontenidos.includes(tag)) {
                // Insertar cierre automáticamente
                const cierre = `</${tag}>`;
                texto += cierre;
                htmlInput.value = texto;

                // Mueve el cursor entre las etiquetas
                const pos = texto.length - cierre.length;
                htmlInput.setSelectionRange(pos, pos);
            }
        }
    }

    // Actualiza el iframe
    const doc = htmlPreview.contentDocument || htmlPreview.contentWindow.document;
    doc.open();
    doc.write(texto);
    doc.close();
});
</script>
@endsection