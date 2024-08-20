// # FUNCS
function getPriceFormat(price) {
    return (parseFloat(price).toFixed(2)).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
}

function hasSpecialChars(str) {
    const regex = /[^A-Za-z0-9]/;
    if (regex.test(str)) return true;
    else return false;
}





// # MODAL
var modal = document.getElementById("epicModal");
var span = document.getElementsByClassName("epic-modal-close")[0];

function epicOpenModal() {
    modal.style.display = "block";
}
span.onclick = function() {
    modal.style.display = "none";
}
window.onclick = function(event) {
    if (event.target == modal) {
        modal.style.display = "none";
    }
}





// # NOTIFICATIONS
function loadDoc(updir = 0)
{
    datadir = "global/getnotif.php";
    for (let i = 0; i < updir; i++) datadir = "../" + datadir;

    setInterval(function(){
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function()
        {
            container = document.getElementById("notifContainer");
            if (this.readyState == 4 && this.status == 200)
            {
                if (this.responseText)
                {
                    const notifnode = document.createElement("div");
                    notifnode.appendChild(document.createTextNode(this.responseText));
                    const closenode = document.createElement("div");
                    closenode.appendChild(document.createTextNode("✖"))
                    
                    closenode.addEventListener('click', function() {
                        notifnode.remove();
                    })

                    notifnode.appendChild(closenode);
                    notifnode.classList.add("epic-notif");
                    container.appendChild(notifnode);
                }
            }
        };
        xhttp.open("GET", datadir, true);
        xhttp.send();
    }, 1000);
}





// # VARIATIONS
class EpicVariation
{
    constructor(id, foodId, name, cost)
    {
        this.id = id;
        this.foodId = foodId;
        this.name = name;
        this.cost = cost;
    }
}
function epicSelectVariation(obj)
{
    container = obj.target.parentElement;
    var children = [].slice.call(container.children);
    children.forEach(c=>{
        c.classList.remove("epic-vActive");
    })

    obj.target.classList.add("epic-vActive");
}





// # RATING
const stars = [
    document.getElementById("epicStar1"),
    document.getElementById("epicStar2"),
    document.getElementById("epicStar3"),
    document.getElementById("epicStar4"),
    document.getElementById("epicStar5")
]
const starsStrings = ["Very Poor", "Poor", "Average", "Good", "Excellent!"]
var starContainer = document.getElementById("epicStarContainer");
var starText = document.getElementById("epicStarText");
var starValue = document.getElementById("epicStarValue");

stars.forEach(star=>{
    star.onmouseover = function()
    {
        tempStars(stars.indexOf(star));
    }
})
stars.forEach(star=>{
    star.onclick = function()
    {
        setStars(stars.indexOf(star));
    }
})
starContainer.onmouseleave = function()
{
    actual = parseInt(starValue.value);
    for (let i = 0; i < 5; i++)
    {
        if (i <= actual - 1) starsC(stars[i]);
        else starsR(stars[i]);
    }
    starText.innerHTML = starsStrings[actual - 1];
}

function starsC(e)
{
    e.classList.remove("epic-startp");
    e.classList.add("epic-starc");
}
function starsTP(e)
{
    e.classList.add("epic-startp");
    e.classList.remove("epic-starc");
}
function starsR(e)
{
    e.classList.remove("epic-startp");
    e.classList.remove("epic-starc");
}
function tempStars(temp)
{
    actual = parseInt(starValue.value);
    for (let i = 0; i < 5; i++)
    {
        if (i <= actual - 1)
        {
            if (i <= temp) starsC(stars[i]);
            else starsTP(stars[i]);
        }
        else
        {
            if (i > temp) starsR(stars[i]);
            else starsTP(stars[i]);
        }
    }
    starText.innerHTML = starsStrings[temp];
}
function setStars(val)
{
    for (let i = 0; i < 5; i++)
    {
        if (i <= val) starsC(stars[i]);
        else starsR(stars[i]);
    }
    starValue.value = (val + 1).toString();
    starText.innerHTML = starsStrings[val];
}