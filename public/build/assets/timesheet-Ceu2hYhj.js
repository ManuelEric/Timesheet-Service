import{r as d,e as X,f as k,w as s,A as N,s as Y,l as U,o as u,b as t,u as l,z as w,W as q,a as e,c as y,X as j,F as A,h as G,n as D,t as p,V as g,j as m,Y as J}from"./main-hx09Hrpa.js";import{a as K}from"./avatar-1-BpD18F9D.js";import{a as O,b as Q,c as Z,d as $}from"./avatar-5-DCc5XOFQ.js";import{d as ee}from"./debounce-D1wdy3__.js";import{V as te,b as ae,a as oe}from"./VCard-D7fXvrE8.js";import{V as z,a as P}from"./VRow-CVTsRxDz.js";import{V as F}from"./VAutocomplete-BJH8Lg-T.js";import{V as le,a as se}from"./VTable-567X0Y2R.js";import{V as re}from"./VPagination-Q3SSnUME.js";import{V as ne}from"./VBadge-CBs1ztD8.js";import{V as H}from"./VTooltip-D-rywHCX.js";import{V as ce}from"./VAvatar-Da3c__KI.js";import"./VImg-CgRfhXmv.js";import"./VList-BbE8kIo3.js";import"./ssrBoot-Va78v84f.js";import"./VDivider-TgHQQllx.js";import"./VCheckboxBtn-BPJSNm-y.js";import"./VSelectionControl-JlkdGNsC.js";import"./VSlideGroup-sCkXUHt4.js";const ie=e("div",{class:"d-flex justify-between align-center"},[e("div",{class:"w-100"},[e("h4",null,"Timesheet List")])],-1),de=e("thead",null,[e("tr",null,[e("th",{class:"text-uppercase",width:"1%"}," No "),e("th",{class:"text-uppercase text-center"},"School/Student Name"),e("th",{class:"text-uppercase text-center"},"Program Name"),e("th",{class:"text-uppercase text-center"},"Package"),e("th",{class:"text-uppercase text-center"},"Tutor/Mentor"),e("th",{class:"text-uppercase text-center"},"PIC"),e("th",{class:"text-uppercase text-center"},"Total Hours"),e("th",{class:"text-uppercase text-center"},"Used"),e("th",{class:"text-uppercase text-center"},"#")])],-1),ue={class:"text-start"},pe={class:"text-left"},me={class:"text-left"},ge={class:"text-left"},_e={class:"text-left"},fe={key:0},ve=e("tr",null,[e("td",{colspan:"9",class:"text-center"}," Sorry, no data found. ")],-1),he=[ve],Ve={class:"d-flex justify-center mt-5"},Re={__name:"timesheet",setup(xe){const L=[K,O,Q,Z,$];d([]);const _=d(1),S=d(),f=d(),T=d([]),c=d(!1),B=d([]),v=d(),I=d([]),h=d(),V=async()=>{var x,a;const r="?page="+_.value,i=f.value?"&keyword="+f.value:"",b=v.value?"&program_name="+encodeURIComponent(v.value):"",C=h.value?"&package_id="+h.value:"",o="&paginate=true";try{c.value=!0;const n=await N.get("api/v1/timesheet/list"+r+i+b+C+o);n&&(_.value=n.current_page,S.value=n.last_page,T.value=n),c.value=!1}catch(n){Y("error",(a=(x=n.response)==null?void 0:x.data)==null?void 0:a.message,"bottom-end"),console.error(n),c.value=!1}},R=async()=>{try{const r=await N.get("api/v1/program/component/list");r&&(B.value=r)}catch(r){console.error(r)}},M=async()=>{try{const r=await N.get("api/v1/package/component/list");r&&(I.value=r)}catch(r){console.error(r)}},E=ee(async()=>{_.value=1,await V()},1e3);return X(()=>{V(),R(),M()}),(r,i)=>{const b=U("VText"),C=U("router-link");return u(),k(te,null,{default:s(()=>[t(ae,null,{default:s(()=>[ie]),_:1}),t(oe,null,{default:s(()=>[t(z,{class:"my-1 justify-space-between"},{default:s(()=>[t(P,{cols:"12",md:"6"},{default:s(()=>[t(z,null,{default:s(()=>[t(P,{cols:"12",md:"6"},{default:s(()=>[t(F,{clearable:"",modelValue:l(v),"onUpdate:modelValue":[i[0]||(i[0]=o=>w(v)?v.value=o:null),V],label:"Program Name",items:l(B),"item-title":"program_name",placeholder:"Select Program Name",variant:"solo",loading:l(c),disabled:l(c)},null,8,["modelValue","items","loading","disabled"])]),_:1}),t(P,{cols:"12",md:"6"},{default:s(()=>[t(F,{clearable:"true",modelValue:l(h),"onUpdate:modelValue":[i[1]||(i[1]=o=>w(h)?h.value=o:null),V],label:"Package",items:l(I),"item-props":o=>({title:o.package!=null?o.type_of+" - "+o.package:o.type_of}),"item-value":"id",placeholder:"Select Package",variant:"solo",loading:l(c),disabled:l(c)},null,8,["modelValue","items","item-props","loading","disabled"])]),_:1})]),_:1})]),_:1}),t(P,{cols:"12",md:"3"},{default:s(()=>[t(q,{loading:l(c),disabled:l(c),"append-inner-icon":"ri-search-line",label:"Search",variant:"solo","hide-details":"","single-line":"",modelValue:l(f),"onUpdate:modelValue":i[2]||(i[2]=o=>w(f)?f.value=o:null),onInput:l(E)},null,8,["loading","disabled","modelValue","onInput"])]),_:1})]),_:1}),l(c)?(u(),k(le,{key:0,class:"mx-auto border",type:"table-thead, table-row@10"})):(u(),k(se,{key:1,class:"text-no-wrap"},{default:s(()=>{var o,x;return[de,e("tbody",null,[(u(!0),y(A,null,j(l(T).data,(a,n)=>(u(),y("tr",{key:n,class:D(a.void=="true"?"bg-secondary":"")},[e("td",null,p(parseInt(n)+1),1),e("td",{class:D(a.group?"cursor-pointer text-left":"text-left")},[a.group?(u(),k(b,{key:0},{default:s(()=>[t(g,{icon:"ri-group-line",class:"me-3"}),m(" "+p(a.clients[0])+" ",1),t(ne,{color:"error",content:a.clients.length-1+"+",inline:""},null,8,["content"]),t(H,{activator:"parent",location:"top",transition:"scroll-y-transition",class:"bg-white"},{default:s(()=>[(u(!0),y(A,null,j(a.clients,W=>(u(),y("div",null,p(W),1))),256))]),_:2},1024)]),_:2},1024)):(u(),k(b,{key:1},{default:s(()=>[t(g,{icon:"ri-user-line",class:"me-3"}),m(" "+p(a.clients),1)]),_:2},1024))],2),e("td",null,[t(g,{icon:"ri-bookmark-3-line",class:"me-3"}),m(" "+p(a.program_name),1)]),e("td",ue,[t(g,{icon:"ri-bookmark-line",class:"me-3"}),m(" "+p(a.detail_package?a.package_type+" - "+a.detail_package:a.package_type),1)]),e("td",pe,[t(ce,{size:"25",class:"avatar-center me-3",image:L[n%5]},null,8,["image"]),m(" "+p(a.tutor_mentor),1)]),e("td",me,[t(g,{icon:"ri-user-line",class:"cursor-pointer me-3"}),m(" "+p(a.admin),1)]),e("td",ge,[t(g,{icon:"ri-calendar-schedule-line",class:"cursor-pointer me-3"}),m(" "+p(a.duration/60)+" Hours ",1)]),e("td",_e,[t(g,{icon:"ri-timer-2-line",class:"cursor-pointer me-3"}),m(" "+p(a.spent/60)+" Hours ",1)]),e("td",null,[t(C,{to:"/admin/timesheet/"+a.id},{default:s(()=>[t(J,{color:a.void=="true"?"light":"secondary"},{default:s(()=>[t(g,{icon:"ri-timeline-view",class:"cursor-pointer"}),t(H,{activator:"parent",location:"top",transition:"scroll-y-transition"},{default:s(()=>[m(" View Detail ")]),_:1})]),_:2},1032,["color"])]),_:2},1032,["to"])])],2))),128))]),((x=(o=l(T))==null?void 0:o.data)==null?void 0:x.length)==0?(u(),y("tfoot",fe,he)):G("",!0)]}),_:1})),e("div",Ve,[t(re,{modelValue:l(_),"onUpdate:modelValue":[i[3]||(i[3]=o=>w(_)?_.value=o:null),V],length:l(S),"total-visible":4,color:"primary","show-first-last-page":!1},null,8,["modelValue","length"])])]),_:1})]),_:1})}}};export{Re as default};
