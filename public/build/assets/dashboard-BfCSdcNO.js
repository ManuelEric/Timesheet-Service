import{r as f,v as h,e as y,f as x,w as t,A as g,o as V,b as e,a as s,x as w,y as C,u as r,z as M,t as p}from"./main-C_ZsSyxB.js";import{_ as b}from"./Qalendar-Dy4F6IOK.js";import{V as v,a as i}from"./VRow-Ch_9Ehhs.js";import{V as n,a as u}from"./VCard-66VJbXIK.js";import"./VAvatar-D8FFqaHs.js";import"./VImg-D9GiVscL.js";const z={class:"d-flex justify-between align-center"},A=s("h3",{class:"font-weight-light w-100"},"Summaries",-1),S={class:"text-primary"},T={class:"text-primary"},$={__name:"dashboard",setup(Y){const o=f(h().format("YYYY-MM")),c=f(!1),d=f(null),m=async _=>{c.value=!0;try{const a=await g.get("api/v1/summarize/"+_);a&&(d.value=a)}catch(a){console.log(a.response)}finally{c.value=!1}};return y(()=>{m(o.value)}),(_,a)=>(V(),x(v,null,{default:t(()=>[e(i,{cols:"12",md:"6"},{default:t(()=>[e(n,{title:"My Calendar"},{default:t(()=>[e(u,null,{default:t(()=>[e(b)]),_:1})]),_:1})]),_:1}),e(i,{cols:"12",md:"6"},{default:t(()=>[e(n,null,{default:t(()=>[e(u,null,{default:t(()=>[s("div",z,[A,s("div",null,[w(s("input",{type:"month",class:"py-1 px-2 border rounded mb-2","onUpdate:modelValue":a[0]||(a[0]=l=>M(o)?o.value=l:null),onChange:a[1]||(a[1]=l=>m(r(o)))},null,544),[[C,r(o)]])])]),e(v,null,{default:t(()=>[e(i,{cols:"6"},{default:t(()=>[e(n,{title:"Total Activity"},{default:t(()=>[e(u,null,{default:t(()=>{var l;return[s("h2",S,p((l=r(d))==null?void 0:l.activity)+" Activities",1)]}),_:1})]),_:1})]),_:1}),e(i,{cols:"6"},{default:t(()=>[e(n,{title:"Total Hours"},{default:t(()=>[e(u,null,{default:t(()=>{var l;return[s("h2",T,p(((l=r(d))==null?void 0:l.total_hours)/60)+" Hours",1)]}),_:1})]),_:1})]),_:1})]),_:1})]),_:1})]),_:1})]),_:1})]),_:1}))}};export{$ as default};
