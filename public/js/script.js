document.getElementById('textArea').addEventListener('focus', function() {
    this.selectionStart = 0; // Define o cursor no início da textarea
});