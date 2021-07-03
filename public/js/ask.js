/*textarea高度自适应*/
$(document).ready(function () {
        $('textarea').each(function () {
            this.setAttribute('style', 'height:4PX' + (this.scrollHeight) + 'px;overflow-y:hidden;');
        }).on('input', function () {
            this.style.height = 'auto'; this.style.height = (this.scrollHeight) + 'px';
        });
    })

