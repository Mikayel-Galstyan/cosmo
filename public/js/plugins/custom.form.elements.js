var checkboxHeight = "20";
var radioHeight = "20";
var selectWidth = "305";

/* No need to change anything after this */

document.write('<style type="text/css">input.styled { opacity: 0; } select.styled { position: relative; width: ' + selectWidth + 'px; opacity: 0; filter: alpha(opacity=0); z-index: 5; } .disabled { opacity: 0.5; filter: alpha(opacity=50); }</style>');

var CustomFormElement = {

    init: function(obj) {
        if(obj){
            obj = document.getElementById(obj);
        }else{
            obj = document.body;
        }
        var onchanged = Array();
        var inputs = document.getElementsByTagName("input"), span = Array(), textnode, option, active;
        for(a = 0; a < inputs.length; a++) {
            if((inputs[a].type == "checkbox" || inputs[a].type == "radio") && inputs[a].className == "styled" && CustomFormElement.isDescendant(obj,inputs[a])) {
                span[a] = document.createElement("span");
                span[a].className = inputs[a].type;

                if(inputs[a].checked == true) {
                    if(inputs[a].type == "checkbox") {
                        position = "0 -" + (checkboxHeight*2) + "px";
                        span[a].style.backgroundPosition = position;
                    } else {
                        position = "0 -" + (radioHeight*2) + "px";
                        span[a].style.backgroundPosition = position;
                    }
                }
                inputs[a].parentNode.insertBefore(span[a], inputs[a]);
                inputs[a].onchange = CustomFormElement.clear;
                if(!inputs[a].getAttribute("disabled")) {
                    span[a].onmousedown = CustomFormElement.pushed;
                    span[a].onmouseup = CustomFormElement.check;
                } else {
                    span[a].className = span[a].className += " disabled";
                }
            }
        }
        inputs = document.getElementsByTagName("select");
        for(a = 0; a < inputs.length; a++) {
            if(inputs[a].className == "styled"  && CustomFormElement.isDescendant(obj,inputs[a])) {
                option = inputs[a].getElementsByTagName("option");
                active = option[0].childNodes[0].nodeValue;
                textnode = document.createTextNode(active);
                for(b = 0; b < option.length; b++) {
                    if(option[b].selected == true) {
                        textnode = document.createTextNode(option[b].childNodes[0].nodeValue);
                    }
                }
                span[a] = document.createElement("span");
                span[a].className = (inputs[a].getAttribute("data-classes"))?inputs[a].getAttribute("data-classes"):'w269';
                span[a].className = span[a].className+' select';
                if(!inputs[a].id){
                    inputs[a].id="selectBox_"+a
                }
                span[a].id = "select" + inputs[a].id;
                span[a].appendChild(textnode);
                inputs[a].parentNode.insertBefore(span[a], inputs[a]);
                if(!inputs[a].getAttribute("disabled")) {
                    onchanged[a]=inputs[a].getAttribute("onchange");
                    inputs[a].setAttribute("data-index","selectBox_"+a);
                    inputs[a].onchange = function(){
                        eval(onchanged[this.getAttribute("data-index").replace("selectBox_",'')]);
                        option = this.getElementsByTagName("option");
                        for(d = 0; d < option.length; d++) {
                            if(option[d].selected == true) {
                                document.getElementById("select" + this.id).childNodes[0].nodeValue = option[d].childNodes[0].nodeValue;
                            }
                        }
                    }
                    
                } else {
                    inputs[a].previousSibling.className = inputs[a].previousSibling.className += " disabled";
                }
            }
        }
        document.onmouseup = CustomFormElement.clear;
    },
    pushed: function() {
        element = this.nextSibling;
        if(element.checked == true && element.type == "checkbox") {
            this.style.backgroundPosition = "0 -" + checkboxHeight*3 + "px";
        } else if(element.checked == true && element.type == "radio") {
            this.style.backgroundPosition = "0 -" + radioHeight*3 + "px";
        } else if(element.checked != true && element.type == "checkbox") {
            this.style.backgroundPosition = "0 -" + checkboxHeight + "px";
        } else {
            this.style.backgroundPosition = "0 -" + radioHeight + "px";
        }
    },
    check: function() {
        element = this.nextSibling;
        if(element.checked == true && element.type == "checkbox") {
            this.style.backgroundPosition = "0 0";
            element.checked = false;
        } else {
            if(element.type == "checkbox") {
                this.style.backgroundPosition = "0 -" + checkboxHeight*2 + "px";
            } else {
                this.style.backgroundPosition = "0 -" + radioHeight*2 + "px";
                group = this.nextSibling.name;
                inputs = document.getElementsByTagName("input");
                for(a = 0; a < inputs.length; a++) {
                    if(inputs[a].name == group && inputs[a] != this.nextSibling) {
                        inputs[a].previousSibling.style.backgroundPosition = "0 0";
                    }
                }
            }
            element.checked = true;
        }
    },
    isDescendant : function(parent, child) {
         var node = child.parentNode;
         while (node != null) {
             if (node == parent) {
                 return true;
             }
             node = node.parentNode;
         }
         return false;
    },
    clear: function() {
        inputs = document.getElementsByTagName("input");
        for(var b = 0; b < inputs.length; b++) {
            if(inputs[b].type == "checkbox" && inputs[b].checked == true && inputs[b].className == "styled") {
                inputs[b].previousSibling.style.backgroundPosition = "0 -" + checkboxHeight*2 + "px";
            } else if(inputs[b].type == "checkbox" && inputs[b].className == "styled") {
                inputs[b].previousSibling.style.backgroundPosition = "0 0";
            } else if(inputs[b].type == "radio" && inputs[b].checked == true && inputs[b].className == "styled") {
                inputs[b].previousSibling.style.backgroundPosition = "0 -" + radioHeight*2 + "px";
            } else if(inputs[b].type == "radio" && inputs[b].className == "styled") {
                inputs[b].previousSibling.style.backgroundPosition = "0 0";
            }
        }
    }
}

$(function(){
	
	$(document).on('focus', 'select.styled', function(){
		$this = $(this).parent().find('span.select');
        
	});
	$(document).on('blur', 'select.styled', function(){
		$this = $(this).parent().find('span.select');
        $this.css('outline', 'none');
	});
	$(document).on('keyup', 'select.styled', function(){
		$(this).change();
	});
	$(document).on('focus', 'input[type="checkbox"].styled', function(){
		$this = $(this).parent().find('span.checkbox');
        $this.css({'outline':'2px solid #34B4E4'});
	});
	$(document).on('blur', 'input[type="checkbox"].styled', function(){
		$this = $(this).parent().find('span.checkbox');
        $this.css('outline', 'none');
	});
	$(document).on('focus', 'input[type="file"]#file', function(){
		$('.upload').css('outline', '2px solid #34B4E4');
	});  
	$(document).on('blur', 'input[type="file"]#file', function(){
		$('.upload').css('outline', 'none');
	});
	$(document).on('change', 'input[type="file"]#file', function(){
		$this = $(this);
        file = $this.val();                    
        $this.siblings().text(file);
	});
   
});
