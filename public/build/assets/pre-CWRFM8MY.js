<<<<<<<< HEAD:public/build/assets/pre-CWRFM8MY.js
import{r as f,e as J,l as E,o as w,f as S,w as a,b as e,Z as L,u as l,W as K,Y,V as C,j as D,m as j,A as M,v as P,s as T,z as A,c as I,F as X,h as q,i as te,P as le,a as s,X as ae,t as h}from"./main-V4Dfl7LH.js";import{r as F}from"./rules-B5G8qOzK.js";import{a as N,c as H,V as B,b as oe}from"./VCard-DUDCLS7w.js";import{V as z}from"./VForm-DfDp2Mnq.js";import{V as O,a as $}from"./VRow-9RudwSAI.js";import{V as Q,a as se}from"./VAutocomplete-DaaTLmYJ.js";import{V as W}from"./VDivider-BiGcHs0h.js";import{d as ne}from"./debounce-DbRZ722j.js";import{V as R}from"./VDialog-iav837Nv.js";import{V as re,a as Z}from"./VList-BwzHL9l4.js";import{a as de,V as ue}from"./VTable-H6ozAXss.js";import{V as ie}from"./VPagination-C63SoP0z.js";import{V as ce}from"./VCheckbox-eLxh71Zt.js";import"./VAvatar-BsuL-Jgk.js";import"./VImg-Dw5XwaZO.js";import"./VCheckboxBtn-CYuSamjD.js";import"./VSelectionControl-CWpMFtZy.js";import"./VSlideGroup-BS2vBEmQ.js";import"./ssrBoot-CKaAtc47.js";const G={__name:"additional_add",props:{title:String},emits:["close","reload"],setup(U,{emit:_}){const b=U,r=_,v=f(),u=f({timesheet_id:null,fee:null,date:null}),m=f([]),y=f(!1),x=async()=>{y.value=!0;try{const n=await M.get("api/v1/timesheet/component/list");n&&(m.value=n)}catch(n){console.error(n)}finally{y.value=!1}},V=async()=>{var c,d;const n=b.title=="bonus"?"api/v1/payment/bonus/create":"api/v1/payment/additional-fee/create",{valid:i}=await v.value.validate();if(i){u.value.date=P(u.value.date).format("YYYY-MM-DD");try{const t=await M.post(n,u.value);t&&T("success",t.message,"bottom-end")}catch(t){const o=(d=(c=t==null?void 0:t.response)==null?void 0:c.data)==null?void 0:d.errors;T("error",o,"bottom-end")}finally{r("close"),r("reload")}}};return J(()=>{x()}),(n,i)=>{const c=E("VDateInput");return w(),S(B,{title:b.title=="bonus"?"Add Bonus":"Additional Fee"},{default:a(()=>[e(N,null,{default:a(()=>[e(z,{onSubmit:L(V,["prevent"]),ref_key:"formData",ref:v},{default:a(()=>[e(O,null,{default:a(()=>[e($,{cols:"12"},{default:a(()=>[e(Q,{modelValue:l(u).timesheet_id,"onUpdate:modelValue":i[0]||(i[0]=d=>l(u).timesheet_id=d),label:"Timesheet - Package",placeholder:"Timesheet - Package",items:l(m),"item-title":d=>d.package_type+" - "+d.package_name+" | "+d.clients,"item-value":"id",variant:"solo",rules:l(F).required,loading:l(y),disabled:l(y)},null,8,["modelValue","items","item-title","rules","loading","disabled"])]),_:1}),e($,{cols:"12"},{default:a(()=>[e(c,{modelValue:l(u).date,"onUpdate:modelValue":i[1]||(i[1]=d=>l(u).date=d),"prepend-icon":"",label:"Date",placeholder:"Date",variant:"solo",rules:l(F).required},null,8,["modelValue","rules"]),e(K,{modelValue:l(u).fee,"onUpdate:modelValue":i[2]||(i[2]=d=>l(u).fee=d),type:"number",label:"Additional Fee",placeholder:"Additional Fee",variant:"solo",rules:l(F).required},null,8,["modelValue","rules"])]),_:1})]),_:1}),e(W,{class:"my-3"}),e(H,null,{default:a(()=>[e(Y,{color:"error",onClick:i[3]||(i[3]=d=>r("close"))},{default:a(()=>[e(C,{icon:"ri-close-line",class:"me-3"}),D(" Close ")]),_:1}),e(j),e(Y,{color:"success",type:"submit"},{default:a(()=>[D(" Save "),e(C,{icon:"ri-save-line",class:"ms-3"})]),_:1})]),_:1})]),_:1},512)]),_:1})]),_:1},8,["title"])}}},me={__name:"cutoff_add",emits:["close","reload"],setup(U,{emit:_}){const b=_,r=f(),v=f({start_date:null,end_date:null}),u=f(null),m=()=>{v.value.start_date=P(u.value[0]).format("YYYY-MM-DD"),v.value.end_date=P(u.value[u.value.length-1]).format("YYYY-MM-DD"),console.log(v.value)},y=async()=>{var n,i,c,d,t,o,k,p;const{valid:x}=await r.value.validate();if(x)try{const g=await M.post("api/v1/payment/cut-off/create",v.value);g&&T("success",g.message,"bottom-end")}catch(g){var V=(i=(n=g==null?void 0:g.response)==null?void 0:n.data)==null?void 0:i.errors;(t=(d=(c=g==null?void 0:g.response)==null?void 0:c.data)==null?void 0:d.errors)!=null&&t.end_date&&(V=(p=(k=(o=g==null?void 0:g.response)==null?void 0:o.data)==null?void 0:k.errors)==null?void 0:p.end_date[0]),T("error",V,"bottom-end")}finally{b("close"),b("reload")}};return(x,V)=>{const n=E("VDateInput");return w(),S(B,{title:"Cut-Off Date"},{default:a(()=>[e(N,null,{default:a(()=>[e(z,{onSubmit:L(y,["prevent"]),ref_key:"formData",ref:r},{default:a(()=>[e(O,null,{default:a(()=>[e($,{cols:"12"},{default:a(()=>[e(n,{modelValue:l(u),"onUpdate:modelValue":[V[0]||(V[0]=i=>A(u)?u.value=i:null),m],variant:"solo",label:"Start - End Date",rules:l(F).required,multiple:"range"},null,8,["modelValue","rules"])]),_:1})]),_:1}),e(W,{class:"my-3"}),e(H,null,{default:a(()=>[e(Y,{color:"error",onClick:V[1]||(V[1]=i=>b("close"))},{default:a(()=>[e(C,{icon:"ri-close-line",class:"me-3"}),D(" Close ")]),_:1}),e(j),e(Y,{color:"success",type:"submit"},{default:a(()=>[D(" Save "),e(C,{icon:"ri-save-line",class:"ms-3"})]),_:1})]),_:1})]),_:1},512)]),_:1})]),_:1})}}},fe={__name:"cutoff_existing_add",props:{id:Array},emits:["close","reload","reset"],setup(U,{emit:_}){const b=U,r=_,v=f(),u=f({activity_id:b.id,start_date:null,end_date:null}),m=f(null),y=()=>{u.value.start_date=P(m.value[0]).format("YYYY-MM-DD"),u.value.end_date=P(m.value[m.value.length-1]).format("YYYY-MM-DD")},x=async()=>{var n,i;const{valid:V}=await v.value.validate();if(V)try{const c=await M.post("api/v1/payment/cut-off/add",u.value);c&&T("success",c.message,"bottom-end")}catch(c){if((i=(n=c==null?void 0:c.response)==null?void 0:n.data)!=null&&i.errors){const d=c.response.data.errors;let t="Validation errors:";for(const o in d)d.hasOwnProperty(o)&&(t+=`
========
import{r as f,e as J,l as E,o as w,f as S,w as a,b as e,Z as L,u as l,W as K,Y,V as C,j as D,m as j,A as M,v as P,s as T,z as A,c as I,F as X,h as q,i as te,P as le,a as s,X as ae,t as h}from"./main-Dnhd_iiv.js";import{r as F}from"./rules-B5G8qOzK.js";import{a as N,c as H,V as B,b as oe}from"./VCard-6WMyhEEp.js";import{V as z}from"./VForm-Da5loNqd.js";import{V as O,a as $}from"./VRow-CFrvXSoG.js";import{V as Q,a as se}from"./VAutocomplete-DLunx94d.js";import{V as W}from"./VDivider-BanKfq9l.js";import{d as ne}from"./debounce-CuqlUFN-.js";import{V as R}from"./VDialog-C0DcI_Hy.js";import{V as re,a as Z}from"./VList-BOUyf6ft.js";import{a as de,V as ue}from"./VTable-DArGt7OT.js";import{V as ie}from"./VPagination-C3yV3swF.js";import{V as ce}from"./VCheckbox-qMK5vf1-.js";import"./VAvatar-CImEaqiH.js";import"./VImg-CehDLjIH.js";import"./VCheckboxBtn-BEGrTcPQ.js";import"./VSelectionControl-B9N-6ZOt.js";import"./VSlideGroup-BITq65FJ.js";import"./ssrBoot-BaSUV1Gb.js";const G={__name:"additional_add",props:{title:String},emits:["close","reload"],setup(U,{emit:_}){const b=U,r=_,v=f(),u=f({timesheet_id:null,fee:null,date:null}),m=f([]),y=f(!1),x=async()=>{y.value=!0;try{const n=await M.get("api/v1/timesheet/component/list");n&&(m.value=n)}catch(n){console.error(n)}finally{y.value=!1}},V=async()=>{var c,d;const n=b.title=="bonus"?"api/v1/payment/bonus/create":"api/v1/payment/additional-fee/create",{valid:i}=await v.value.validate();if(i){u.value.date=P(u.value.date).format("YYYY-MM-DD");try{const t=await M.post(n,u.value);t&&T("success",t.message,"bottom-end")}catch(t){const o=(d=(c=t==null?void 0:t.response)==null?void 0:c.data)==null?void 0:d.errors;T("error",o,"bottom-end")}finally{r("close"),r("reload")}}};return J(()=>{x()}),(n,i)=>{const c=E("VDateInput");return w(),S(B,{title:b.title=="bonus"?"Add Bonus":"Additional Fee"},{default:a(()=>[e(N,null,{default:a(()=>[e(z,{onSubmit:L(V,["prevent"]),ref_key:"formData",ref:v},{default:a(()=>[e(O,null,{default:a(()=>[e($,{cols:"12"},{default:a(()=>[e(Q,{modelValue:l(u).timesheet_id,"onUpdate:modelValue":i[0]||(i[0]=d=>l(u).timesheet_id=d),label:"Timesheet - Package",placeholder:"Timesheet - Package",items:l(m),"item-title":d=>d.package_type+" - "+d.package_name+" | "+d.clients,"item-value":"id",variant:"solo",rules:l(F).required,loading:l(y),disabled:l(y)},null,8,["modelValue","items","item-title","rules","loading","disabled"])]),_:1}),e($,{cols:"12"},{default:a(()=>[e(c,{modelValue:l(u).date,"onUpdate:modelValue":i[1]||(i[1]=d=>l(u).date=d),"prepend-icon":"",label:"Date",placeholder:"Date",variant:"solo",rules:l(F).required},null,8,["modelValue","rules"]),e(K,{modelValue:l(u).fee,"onUpdate:modelValue":i[2]||(i[2]=d=>l(u).fee=d),type:"number",label:"Additional Fee",placeholder:"Additional Fee",variant:"solo",rules:l(F).required},null,8,["modelValue","rules"])]),_:1})]),_:1}),e(W,{class:"my-3"}),e(H,null,{default:a(()=>[e(Y,{color:"error",onClick:i[3]||(i[3]=d=>r("close"))},{default:a(()=>[e(C,{icon:"ri-close-line",class:"me-3"}),D(" Close ")]),_:1}),e(j),e(Y,{color:"success",type:"submit"},{default:a(()=>[D(" Save "),e(C,{icon:"ri-save-line",class:"ms-3"})]),_:1})]),_:1})]),_:1},512)]),_:1})]),_:1},8,["title"])}}},me={__name:"cutoff_add",emits:["close","reload"],setup(U,{emit:_}){const b=_,r=f(),v=f({start_date:null,end_date:null}),u=f(null),m=()=>{v.value.start_date=P(u.value[0]).format("YYYY-MM-DD"),v.value.end_date=P(u.value[u.value.length-1]).format("YYYY-MM-DD"),console.log(v.value)},y=async()=>{var n,i,c,d,t,o,k,p;const{valid:x}=await r.value.validate();if(x)try{const g=await M.post("api/v1/payment/cut-off/create",v.value);g&&T("success",g.message,"bottom-end")}catch(g){var V=(i=(n=g==null?void 0:g.response)==null?void 0:n.data)==null?void 0:i.errors;(t=(d=(c=g==null?void 0:g.response)==null?void 0:c.data)==null?void 0:d.errors)!=null&&t.end_date&&(V=(p=(k=(o=g==null?void 0:g.response)==null?void 0:o.data)==null?void 0:k.errors)==null?void 0:p.end_date[0]),T("error",V,"bottom-end")}finally{b("close"),b("reload")}};return(x,V)=>{const n=E("VDateInput");return w(),S(B,{title:"Cut-Off Date"},{default:a(()=>[e(N,null,{default:a(()=>[e(z,{onSubmit:L(y,["prevent"]),ref_key:"formData",ref:r},{default:a(()=>[e(O,null,{default:a(()=>[e($,{cols:"12"},{default:a(()=>[e(n,{modelValue:l(u),"onUpdate:modelValue":[V[0]||(V[0]=i=>A(u)?u.value=i:null),m],variant:"solo",label:"Start - End Date",rules:l(F).required,multiple:"range"},null,8,["modelValue","rules"])]),_:1})]),_:1}),e(W,{class:"my-3"}),e(H,null,{default:a(()=>[e(Y,{color:"error",onClick:V[1]||(V[1]=i=>b("close"))},{default:a(()=>[e(C,{icon:"ri-close-line",class:"me-3"}),D(" Close ")]),_:1}),e(j),e(Y,{color:"success",type:"submit"},{default:a(()=>[D(" Save "),e(C,{icon:"ri-save-line",class:"ms-3"})]),_:1})]),_:1})]),_:1},512)]),_:1})]),_:1})}}},fe={__name:"cutoff_existing_add",props:{id:Array},emits:["close","reload","reset"],setup(U,{emit:_}){const b=U,r=_,v=f(),u=f({activity_id:b.id,start_date:null,end_date:null}),m=f(null),y=()=>{u.value.start_date=P(m.value[0]).format("YYYY-MM-DD"),u.value.end_date=P(m.value[m.value.length-1]).format("YYYY-MM-DD")},x=async()=>{var n,i;const{valid:V}=await v.value.validate();if(V)try{const c=await M.post("api/v1/payment/cut-off/add",u.value);c&&T("success",c.message,"bottom-end")}catch(c){if((i=(n=c==null?void 0:c.response)==null?void 0:n.data)!=null&&i.errors){const d=c.response.data.errors;let t="Validation errors:";for(const o in d)d.hasOwnProperty(o)&&(t+=`
>>>>>>>> origin/production:public/build/assets/pre-DqYTuWmz.js
${o}: ${d[o].join(", ")}`);T("error",t,"bottom-end")}}finally{r("reload"),r("close"),r("reset")}};return(V,n)=>{const i=E("VDateInput");return w(),S(B,{title:"Add to Cut-Off"},{default:a(()=>[e(N,null,{default:a(()=>[e(z,{onSubmit:L(x,["prevent"]),ref_key:"formData",ref:v},{default:a(()=>[e(O,null,{default:a(()=>[e($,{cols:"12"},{default:a(()=>[e(i,{modelValue:l(m),"onUpdate:modelValue":[n[0]||(n[0]=c=>A(m)?m.value=c:null),y],label:"Start - End Date",variant:"solo",rules:l(F).required,multiple:"range"},null,8,["modelValue","rules"])]),_:1})]),_:1}),e(W,{class:"my-3"}),e(H,null,{default:a(()=>[e(Y,{color:"error",onClick:n[1]||(n[1]=c=>r("close"))},{default:a(()=>[e(C,{icon:"ri-close-line",class:"me-3"}),D(" Close ")]),_:1}),e(j),e(Y,{color:"success",type:"submit"},{default:a(()=>[D(" Save "),e(C,{icon:"ri-save-line",class:"ms-3"})]),_:1})]),_:1})]),_:1},512)]),_:1})]),_:1})}}},pe=s("div",{class:"d-flex justify-between align-center"},[s("div",{class:"w-100"},[s("h4",null,"Pre Cut-Off")])],-1),_e=s("thead",null,[s("tr",null,[s("th",{class:"text-uppercase",width:"1%"}," # "),s("th",{class:"text-uppercase",width:"1%"}," No "),s("th",{class:"text-uppercase text-center"},"Timesheet"),s("th",{class:"text-uppercase text-center"},"Activity"),s("th",{class:"text-uppercase text-center"},"Students Name"),s("th",{class:"text-uppercase text-center"},"Mentor/Tutor"),s("th",{class:"text-uppercase text-center"},"Date & Time"),s("th",{class:"text-uppercase text-center"},"Time Spent"),s("th",{class:"text-uppercase text-center"},"Fee/Hours"),s("th",{class:"text-uppercase text-center"},"Total"),s("th",{class:"text-uppercase text-center"},"Cut-Offf Status")])],-1),ve={class:"text-center"},Ve={key:0},ge=s("tr",null,[s("td",{colspan:"10",class:"text-center"}," Sorry, no data found. ")],-1),ye=[ge],be={class:"d-flex justify-center mt-5"},Oe={__name:"pre",setup(U){const _=f(!1),b=f([]),r=f({cut_off:!1,additional_fee:!1,add_bonus:!1,add_existing:!1}),v=f(1),u=f(),m=f([]),y=f(null),x=f(null),V=f([]),n=async()=>{_.value=!0;const d="?page="+v.value,t=y.value?"&keyword="+y.value:"",o=x.value?"&package_id="+x.value:"";try{const k=await M.get("api/v1/payment/unpaid"+d+t+o);k&&(v.value=k.current_page,u.value=k.last_page,b.value=k)}catch(k){console.error(k)}finally{_.value=!1}},i=ne(async()=>{await n()},500),c=async()=>{_.value=!0;try{const d=await M.get("api/v1/package/component/list");d&&(V.value=d,_.value=!1)}catch(d){_.value=!1,console.error(d)}};return J(()=>{n(),c()}),(d,t)=>(w(),I(X,null,[e(B,null,{default:a(()=>[e(oe,null,{default:a(()=>[pe]),_:1}),e(N,null,{default:a(()=>[e(O,{class:"my-1"},{default:a(()=>[e($,{cols:"3",md:"4"},{default:a(()=>[e(Q,{loading:l(_),disabled:l(_),clearable:"true",label:"Package Name",items:l(V),"item-title":o=>o.type_of+" - "+o.package,"item-value":"id",modelValue:l(x),"onUpdate:modelValue":[t[0]||(t[0]=o=>A(x)?x.value=o:null),n],placeholder:"Select Timesheet Package",density:"compact",variant:"solo"},null,8,["loading","disabled","items","item-title","modelValue"])]),_:1}),e($,{cols:"3",md:"3"},{default:a(()=>[e(K,{loading:l(_),disabled:l(_),"prepend-inner-icon":"ri-search-line",density:"compact",label:"Search",variant:"solo","hide-details":"","single-line":"",modelValue:l(y),"onUpdate:modelValue":t[1]||(t[1]=o=>A(y)?y.value=o:null),onInput:l(i)},null,8,["loading","disabled","modelValue","onInput"])]),_:1}),e($,{cols:"6",md:"5",class:"text-end"},{default:a(()=>[l(m).length>0?(w(),S(Y,{key:0,color:"warning",class:"me-1",onClick:t[2]||(t[2]=o=>l(r).add_existing=!0)},{default:a(()=>[e(C,{icon:"ri-add-box-line",class:"me-2"}),D(" Add to Existing Cut-Off ")]),_:1})):q("",!0),e(te,{"close-on-content-click":!1,location:"bottom"},{activator:a(({props:o})=>[e(Y,le({color:"light-primary"},o,{class:"me-1"}),{default:a(()=>[D(" Additional Fee "),e(C,{icon:"ri-arrow-down-s-line",class:"ms-2"})]),_:2},1040)]),default:a(()=>[e(re,null,{default:a(()=>[e(Z,null,{default:a(()=>[s("div",{class:"cursor-pointer",onClick:t[3]||(t[3]=o=>l(r).additional_fee=!0)},[e(C,{icon:"ri-wallet-2-line",class:"me-2"}),D(" Additional Fee ")])]),_:1}),e(Z,null,{default:a(()=>[s("div",{class:"cursor-pointer",onClick:t[4]||(t[4]=o=>l(r).add_bonus=!0)},[e(C,{icon:"ri-wallet-3-line",class:"me-2"}),D(" Add Bonus ")])]),_:1})]),_:1})]),_:1}),l(m).length==0?(w(),S(Y,{key:1,color:"secondary",onClick:t[5]||(t[5]=o=>l(r).cut_off=!0)},{default:a(()=>[e(C,{icon:"ri-scissors-cut-line",class:"me-2"}),D(" Cut-Off ")]),_:1})):q("",!0)]),_:1})]),_:1}),l(_)?(w(),S(ue,{key:0,class:"mx-auto border",type:"table-thead, table-row@10"})):(w(),S(de,{key:1,class:"text-no-wrap"},{default:a(()=>{var o,k;return[_e,s("tbody",null,[(w(!0),I(X,null,ae(l(b).data,(p,g)=>(w(),I("tr",{key:g},[s("td",null,[e(ce,{modelValue:l(m),"onUpdate:modelValue":t[6]||(t[6]=ee=>A(m)?m.value=ee:null),value:p.id},null,8,["modelValue","value"])]),s("td",null,h(parseInt(g)+1),1),s("td",null,h(p.package.type+" - "+p.package.name),1),s("td",null,h(p.activity),1),s("td",null,h(p.students),1),s("td",null,h(p.mentor_tutor),1),s("td",null,h(p.date),1),s("td",null,h((p.time_spent/60).toFixed(2)+" Hours"),1),s("td",null,"Rp. "+h(p.fee_hours),1),s("td",null," Rp. "+h((p.time_spent/60).toFixed(2)*p.fee_hours),1),s("td",ve,[e(se,{color:p.cutoff_status=="not yet"?"#ff0217":"#91c45e"},{default:a(()=>[D(h(p.cutoff_status.charAt(0).toUpperCase()+p.cutoff_status.slice(1).toLowerCase()),1)]),_:2},1032,["color"])])]))),128))]),((k=(o=l(b))==null?void 0:o.data)==null?void 0:k.length)==0?(w(),I("tfoot",Ve,ye)):q("",!0)]}),_:1})),s("div",be,[e(ie,{modelValue:l(v),"onUpdate:modelValue":[t[7]||(t[7]=o=>A(v)?v.value=o:null),n],length:l(u),"total-visible":4,color:"primary",density:"compact","show-first-last-page":!1},null,8,["modelValue","length"])])]),_:1}),e(R,{modelValue:l(r).cut_off,"onUpdate:modelValue":t[9]||(t[9]=o=>l(r).cut_off=o),"max-width":"450",persistent:""},{default:a(()=>[e(me,{onClose:t[8]||(t[8]=o=>l(r).cut_off=!1),onReload:n})]),_:1},8,["modelValue"]),e(R,{modelValue:l(r).add_existing,"onUpdate:modelValue":t[12]||(t[12]=o=>l(r).add_existing=o),"max-width":"450",persistent:"",scrollable:""},{default:a(()=>[e(fe,{id:l(m),onClose:t[10]||(t[10]=o=>l(r).add_existing=!1),onReload:n,onReset:t[11]||(t[11]=o=>m.value=[])},null,8,["id"])]),_:1},8,["modelValue"])]),_:1}),e(R,{modelValue:l(r).add_bonus,"onUpdate:modelValue":t[14]||(t[14]=o=>l(r).add_bonus=o),"max-width":"450",persistent:""},{default:a(()=>[e(G,{title:"bonus",onClose:t[13]||(t[13]=o=>l(r).add_bonus=!1),onReload:n})]),_:1},8,["modelValue"]),e(R,{modelValue:l(r).additional_fee,"onUpdate:modelValue":t[16]||(t[16]=o=>l(r).additional_fee=o),"max-width":"450",persistent:""},{default:a(()=>[e(G,{title:"fee",onClose:t[15]||(t[15]=o=>l(r).additional_fee=!1),onReload:n})]),_:1},8,["modelValue"])],64))}};export{Oe as default};
