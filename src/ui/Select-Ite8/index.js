import { genericRenderer } from "../../lib/utils.js"; 

const templateFile = await fetch("./src/ui/Select-Ite8/template.html");
const template = await templateFile.text();


// fais le replace pour modifier le select 


let SelectMovieView = {

    
    render: function( data) {
        let html = "";

        for(let obj of data){
            html += genericRenderer(template, obj);
        }
        return html;
    
    }
};




export {SelectMovieView};


  