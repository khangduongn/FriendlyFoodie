function ToggleContainer(button_id, container_id, button_value_close, button_value_open){
    //if the add ingredient button doesn't have the class "opened"
    if(!$(button_id).hasClass("opened")){
        
        //open the form
        $(container_id).show();
        $(button_id).addClass("opened");
        $(button_id).html(button_value_open);


    }else{
        //code for close
        $(container_id).hide();
        $(button_id).removeClass("opened");
        $(button_id).html(button_value_close);
    }  

}


function ToggleEdit(edit_button_id, delete_button_id, save_button_id, container_id_input, container_id_display, button_value_close, button_value_open){
    //if the add ingredient button doesn't have the class "opened"
    if(!$(edit_button_id).hasClass("opened")){
        
        //open the container
        $(container_id_input).show();

        $(container_id_display).hide();

        $(save_button_id).show();


        $(edit_button_id).addClass("opened");
        $(edit_button_id).html(button_value_open);



        $(delete_button_id).hide();


    }else{
        //close container
        $(container_id_input).hide();

        $(container_id_display).show();

        $(edit_button_id).removeClass("opened");
        $(edit_button_id).html(button_value_close);
        $(save_button_id).hide();
        $(delete_button_id).show();

        
    }  

}