ddaccordion.init({
    headerclass: "headerTitle",
    contentclass: "accordionContent",
    revealtype: "click",
    mouseoverdelay: 200,
    collapseprev: true,
    defaultexpanded: [],
    onemustopen: false,
    animatedefault: true,
    scrolltoheader: false,
    persiststate: true,
    toggleclass: ["", ""],
    togglehtml: ["none", "", ""],
    animatespeed: "fast",
    oninit:function(expandedindices){
    },
    onopenclose:function(header, index, state, isuseractivated){
    }
});
