
function validation()
{
    var state = document.getElementById("state");
    var flagReturn = true;

    if(state.value == 0)
    {
        state.className = "errclass";
        flagReturn = false;
    }
    else 
    {
        state.className = "";
    }

    return flagReturn;
} 
