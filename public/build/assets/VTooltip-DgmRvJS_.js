import{B as S,b5 as h,bC as O,D as x,E as T,bD as p,L as C,K as e,r as k,P as u,M as w,bE as d,b as A,bc as B}from"./main-qXfsbDxV.js";const D=S({id:String,text:String,...h(O({closeOnBack:!1,location:"end",locationStrategy:"connected",eager:!0,minWidth:0,offset:10,openOnClick:!1,openOnHover:!0,origin:"auto",scrim:!1,scrollStrategy:"reposition",transition:!1}),["absolute","persistent"])},"VTooltip"),I=x()({name:"VTooltip",props:D(),emits:{"update:modelValue":t=>!0},setup(t,v){let{slots:a}=v;const n=T(t,"modelValue"),{scopeId:g}=p(),f=C(),r=e(()=>t.id||`v-tooltip-${f}`),l=k(),m=e(()=>t.location.split(" ").length>1?t.location:t.location+" center"),b=e(()=>t.origin==="auto"||t.origin==="overlap"||t.origin.split(" ").length>1||t.location.split(" ").length>1?t.origin:t.origin+" center"),V=e(()=>t.transition?t.transition:n.value?"scale-transition":"fade-transition"),P=e(()=>u({"aria-describedby":r.value},t.activatorProps));return w(()=>{const y=d.filterProps(t);return A(d,u({ref:l,class:["v-tooltip",t.class],style:t.style,id:r.value},y,{modelValue:n.value,"onUpdate:modelValue":o=>n.value=o,transition:V.value,absolute:!0,location:m.value,origin:b.value,persistent:!0,role:"tooltip",activatorProps:P.value,_disableGlobalStack:!0},g),{activator:a.activator,default:function(){var c;for(var o=arguments.length,s=new Array(o),i=0;i<o;i++)s[i]=arguments[i];return((c=a.default)==null?void 0:c.call(a,...s))??t.text}})}),B({},l)}});export{I as V};
