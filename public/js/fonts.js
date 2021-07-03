$(function (){
        if("fonts" in document) {
            
            document.fonts.load("1em 兰亭粗黑简");
            document.fonts.load("1em 兰亭黑简");
            document.fonts.ready.then(function(fontFaceSet){
                document.documentElement.className += " lt";
                document.documentElement.className += " fz";
            })
        }
})

