import{r as u,v as p,e as g,f as y,w as s,A as x,o as V,b as e,a as t,x as b,y as z,u as i,z as k,t as _,V as f}from"./main-DiavuC11.js";import{_ as C}from"./Qalendar-HjObPlwZ.js";import{V as w,a as n}from"./VRow-BWRkT_yo.js";import{V as d,a as r}from"./VCard-Y-T-Ka0a.js";import"./VAvatar-CjmHWuvR.js";import"./VImg-DVMV4Jyj.js";const M={class:"d-flex justify-between align-center"},j=t("h3",{class:"font-weight-light w-100"},"Summaries",-1),N={class:"w-50 d-flex justify-end"},S={class:"d-flex justify-between align-center"},Y={class:"w-100"},A=t("h4",{class:"font-weight-light"},"New Program",-1),B={class:"text-end w-25"},T={class:"d-flex justify-between align-center"},D={class:"w-100"},R=t("h4",{class:"font-weight-light"},"New Timesheet",-1),$={class:"text-end w-25"},I={class:"d-flex justify-between align-center"},P={class:"w-100"},U=t("h4",{class:"font-weight-light"},"New Activity",-1),q={class:"text-end w-25"},O={__name:"dashboard",setup(E){const o=u(p().format("YYYY-MM")),h=u(!1),c=u(null),m=async v=>{h.value=!0;try{const a=await x.get("api/v1/summarize/"+v);a&&(c.value=a)}catch(a){console.log(a.response)}finally{h.value=!1}};return g(()=>{m(o.value)}),(v,a)=>(V(),y(w,null,{default:s(()=>[e(n,{cols:"12",md:"6"},{default:s(()=>[e(d,{title:"My Calendar"},{default:s(()=>[e(r,null,{default:s(()=>[e(C)]),_:1})]),_:1})]),_:1}),e(n,{cols:"12",md:"6"},{default:s(()=>[e(d,null,{default:s(()=>[e(r,null,{default:s(()=>[t("div",M,[j,t("div",N,[t("div",null,[b(t("input",{type:"month",class:"py-1 px-2 border rounded mb-2","onUpdate:modelValue":a[0]||(a[0]=l=>k(o)?o.value=l:null),onChange:a[1]||(a[1]=l=>m(i(o)))},null,544),[[z,i(o)]])])])]),e(w,{class:"mt-4"},{default:s(()=>[e(n,{md:"6"},{default:s(()=>[e(d,null,{default:s(()=>[e(r,null,{default:s(()=>{var l;return[t("div",S,[t("div",Y,[t("h2",null,_((l=i(c))==null?void 0:l.program),1),A]),t("div",B,[e(f,{icon:"ri-bookmark-3-line",size:"30",color:"primary"})])])]}),_:1})]),_:1})]),_:1}),e(n,{md:"6"},{default:s(()=>[e(d,null,{default:s(()=>[e(r,null,{default:s(()=>{var l;return[t("div",T,[t("div",D,[t("h2",null,_((l=i(c))==null?void 0:l.timesheet),1),R]),t("div",$,[e(f,{icon:"ri-calendar-schedule-line",size:"30",color:"error"})])])]}),_:1})]),_:1})]),_:1}),e(n,{md:"6"},{default:s(()=>[e(d,null,{default:s(()=>[e(r,null,{default:s(()=>{var l;return[t("div",I,[t("div",P,[t("h2",null,_((l=i(c))==null?void 0:l.activity),1),U]),t("div",q,[e(f,{icon:"ri-task-line",size:"30",color:"warning"})])])]}),_:1})]),_:1})]),_:1})]),_:1})]),_:1})]),_:1})]),_:1})]),_:1}))}};export{O as default};
