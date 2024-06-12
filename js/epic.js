// # FUNCS
function getPriceFormat(price) {
    return (parseFloat(price).toFixed(2)).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
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