import{a as p,c as C,V as f}from"./VCard--A0TG-0k.js";import{aE as h,l as V,o as x,f as D,w as t,b as e,a as s,j as o,t as g,m as c,Y as n,V as i}from"./main-DHXZBRQ4.js";const k=s("h2",{class:"my-3 mb-4"},"Confirmation",-1),B={class:"font-weight-light"},b=s("br",null,null,-1),A=h({__name:"DeleteHandler",props:["data","title"],emits:["close","delete"],setup(r,{emit:d}){const m=r,a=d,l=()=>{a("close")},_=()=>{a("delete")};return(w,y)=>{const u=V("DialogCloseBtn");return x(),D(f,null,{default:t(()=>[e(u,{variant:"text",size:"default",onClick:l}),e(p,{class:"text-center mt-4"},{default:t(()=>[k,s("h3",B,[o(" Are you sure, "),b,o(" you want to delete this "+g(m.title)+" ? ",1)])]),_:1}),e(C,{class:"mb-3"},{default:t(()=>[e(c),e(n,{color:"error",onClick:l},{default:t(()=>[e(i,{icon:"ri-close-line",class:"me-2"}),o(" Cancel ")]),_:1}),e(n,{color:"success",onClick:_},{default:t(()=>[e(i,{icon:"ri-check-line",class:"me-2"}),o(" Yes, Delete ")]),_:1}),e(c)]),_:1})]),_:1})}}});export{A as _};
