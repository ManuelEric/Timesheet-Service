import{o as s,c as o,t as a,h as r,a6 as u,K as p,b as t,a as _,u as c,w as h,Y as g,j as f}from"./main-C_ZsSyxB.js";import{V as n}from"./VImg-D9GiVscL.js";const k={class:"text-center mb-4"},b={key:0,class:"text-h1 font-weight-medium"},x={key:1,class:"text-h5 font-weight-medium mb-3"},y={key:2},w={__name:"ErrorHeader",props:{statusCode:{type:[String,Number],required:!1},title:{type:String,required:!1},description:{type:String,required:!1}},setup(i){const e=i;return(d,m)=>(s(),o("div",k,[e.statusCode?(s(),o("h1",b,a(e.statusCode),1)):r("",!0),e.title?(s(),o("h5",x,a(e.title),1)):r("",!0),e.description?(s(),o("p",y,a(e.description),1)):r("",!0)]))}},V="/build/assets/404-KybqypYR.png",v="/build/assets/misc-mask-dark-EDTHQMEO.png",C="/build/assets/misc-mask-light-PdlO0S62.png",N="/build/assets/tree-3HmZpwoD.png",S={class:"misc-wrapper"},B={class:"misc-avatar w-100 text-center"},q={__name:"[...error]",setup(i){const e=u(),d=p(()=>e.global.name.value==="light"?C:v);return(m,E)=>{const l=w;return s(),o("div",S,[t(l,{"status-code":"404",title:"Page Not Found ⚠️",description:"We couldn't find the page you are looking for."}),_("div",B,[t(n,{src:c(V),alt:"Coming Soon","max-width":800,class:"mx-auto"},null,8,["src"]),t(g,{to:"/",class:"mt-10"},{default:h(()=>[f(" Back to Home ")]),_:1})]),t(n,{src:c(N),class:"misc-footer-tree d-none d-md-block"},null,8,["src"]),t(n,{src:c(d),class:"misc-footer-img d-none d-md-block"},null,8,["src"])])}}};export{q as default};
