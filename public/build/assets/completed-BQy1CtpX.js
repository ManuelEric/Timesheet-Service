<<<<<<<< HEAD:public/build/assets/completed-BQy1CtpX.js
import{o as v,c as O,a,d as J,b as t,V as C,w as s,u as o,n as re,a5 as ue,j as Y,r as d,e as ie,z as b,F as K,v as k,A as D,l as ce,W as de,Z as pe,Y as $,m as fe,x as j,f as I,h as Q,X as me,t as f,a0 as ve,s as R,a2 as _e,a3 as he}from"./main-V4Dfl7LH.js";import{r as ye}from"./rules-B5G8qOzK.js";import{a as z,V as E,c as Ve,b as ge}from"./VCard-DUDCLS7w.js";import{d as be}from"./debounce-DbRZ722j.js";import{V as we}from"./VDialog-iav837Nv.js";import{V as B,a as w}from"./VRow-9RudwSAI.js";import{V as P,a as xe}from"./VAutocomplete-DaaTLmYJ.js";import{V as ke}from"./VForm-DfDp2Mnq.js";import{V as ee}from"./VCheckbox-eLxh71Zt.js";import{a as De,V as Ce}from"./VTable-H6ozAXss.js";import{V as Ye}from"./VPagination-C63SoP0z.js";import{T as L}from"./index-DDZGCL-4.js";import"./VAvatar-BsuL-Jgk.js";import"./VImg-Dw5XwaZO.js";import"./VList-BwzHL9l4.js";import"./ssrBoot-CKaAtc47.js";import"./VDivider-BiGcHs0h.js";import"./VCheckboxBtn-CYuSamjD.js";import"./VSelectionControl-CWpMFtZy.js";import"./VSlideGroup-BS2vBEmQ.js";import"./VTooltip-CbVa9cMY.js";const Te={class:"position-relative overflow-hidden"},Se={class:"d-flex justify-space-between"},Me={class:"text-secondary"},Fe={__name:"FilterSidebar",props:{active:Boolean,width:Number},emits:["close"],setup(H,{emit:r}){const V=H,A=r;return(m,i)=>(v(),O("section",Te,[a("div",{class:re(["position-fixed filter-content",V.active?"active":""]),style:ue({width:V.width+"px"})},[a("div",Se,[a("h3",Me,[J(m.$slots,"header",{},()=>[Y("Title")])]),a("div",{onClick:i[0]||(i[0]=T=>A("close"))},[t(C,{icon:"ri-close-line",color:"#e08282",class:"cursor-pointer"})])]),t(o(E),{class:"mt-3"},{default:s(()=>[t(o(z),null,{default:s(()=>[J(m.$slots,"content",{},()=>[Y("Content")])]),_:3})]),_:3})],6)]))}},Ue=a("div",{class:"d-flex justify-between align-center"},[a("div",{class:"w-100"},[a("h4",null,"Completed Cut-Off")])],-1),Ne=a("thead",null,[a("tr",null,[a("th",{class:"text-uppercase"},"#"),a("th",{class:"text-uppercase text-center"},"Timesheet"),a("th",{class:"text-uppercase text-center"},"Activity"),a("th",{class:"text-uppercase text-center"},"Students Name"),a("th",{class:"text-uppercase text-center"},"Activity Date"),a("th",{class:"text-uppercase text-center"},"Mentor/Tutor"),a("th",{class:"text-uppercase text-center"},"Time Spent"),a("th",{class:"text-uppercase text-center"},"Fee/Hours"),a("th",{class:"text-uppercase text-center"},"Total"),a("th",{class:"text-uppercase text-center"},"Cut-Off Date"),a("th",{class:"text-uppercase text-center"},"Cut-Off Status")])],-1),$e={class:"text-center"},Ie={class:"text-center text-capitalize"},Oe=a("th",{colspan:"9"},"Total Fee",-1),Ae={colspan:"2",class:"text-end"},Re={key:0},je=a("tr",null,[a("td",{colspan:"10",class:"text-center"}," Sorry, no data found. ")],-1),Be=[je],Pe={class:"d-flex justify-center mt-5"},it={__name:"completed",setup(H){const r=d(!1),V=d([]),A=d(),m=d(!1),i=d({cut_off_date:[],specific:!1,timesheet_id:null}),T=d(!1),S=d(1),q=d(),x=d([]),M=d(null),F=d(null),W=d([]),U=d(null),X=d([]),Z=d([]),h=d(null),g=async()=>{r.value=!0;const n="?page="+S.value,l=M.value?"&keyword="+M.value:"",c=F.value?"&package_id="+F.value:"",e=h.value?"&cutoff_start="+k(h.value[0]).format("YYYY-MM-DD"):"",p=h.value?"&cutoff_end="+k(h.value[h.value.length-1]).format("YYYY-MM-DD"):"",u=U.value?"&mentor_id="+U.value:"",y="api/v1/payment/paid"+n+l+c+e+p+u;try{const _=await D.get(y);_&&(S.value=_.current_page,q.value=_.last_page,V.value=_)}catch(_){console.error(_)}finally{r.value=!1}},G=be(async()=>{await g()},1e3),te=async()=>{r.value=!0;try{const n=await D.get("api/v1/package/component/list");n&&(W.value=n,r.value=!1)}catch(n){r.value=!1,console.error(n)}},ae=async()=>{r.value=!0;try{const n=await D.get("api/v1/user/mentor-tutors");n&&(X.value=n,r.value=!1)}catch(n){r.value=!1,console.error(n)}},le=async()=>{const n=await ve("Are you sure you want to cancel this activity?"),l={activity_id:Object.keys(x.value).map(c=>x.value[c])};if(n){r.value=!0;try{const c=await D.patch("api/v1/payment/cut-off/unassign",l);c&&(R("success",c.message,"bottom-end"),g())}catch(c){R("error",c.response.statusText,"bottom-end")}finally{r.value=!1}}},oe=async()=>{let n=i.value.cut_off_date,l=k(n[0]).format("YYYY-MM-DD"),c=k(n[n.length-1]).format("YYYY-MM-DD");const e="api/v1/timesheet/component/list?cutoff_start="+l+"&cutoff_end="+c;r.value=!0;try{const p=await D.get(e);p&&(Z.value=p,r.value=!1)}catch(p){r.value=!1,console.error(p)}},se=()=>{i.value.cut_off_date=[],i.value.specific=!1,i.value.timesheet_id=null},ne=async()=>{let n=i.value.cut_off_date,l=k(n[0]).format("YYYY-MM-DD"),c=k(n[n.length-1]).format("YYYY-MM-DD"),p="api/v1/payment/cut-off/export"+(i.value.specific?"/"+i.value.timesheet_id:"")+"/"+l+"/"+c;const{valid:u}=await A.value.validate();if(u){m.value=!1,_e();try{const y=await D.get(p,{responseType:"blob"});if(y){const _=window.URL.createObjectURL(new Blob([y],{type:'"application/vnd.openxmlformats-officedocument.spreadsheetml.sheet"'})),N=document.createElement("a");N.href=_,N.setAttribute("download",`payroll_${l}_${c}.xlsx`),document.body.appendChild(N),N.click(),document.body.removeChild(N),window.URL.revokeObjectURL(_),he.close(),R("success","Successfully downloaded","bottom-end")}}catch(y){m.value=!0,R("error","Cut-Off date is not found!","bottom-end"),console.log(y)}finally{se()}}};return ie(()=>{g(),te(),ae()}),(n,l)=>{const c=ce("VDateInput");return v(),O(K,null,[t(Fe,{active:o(T),width:450,onClose:l[4]||(l[4]=e=>T.value=!1)},{header:s(()=>[Y(" Filter ")]),content:s(()=>[t(B,{class:"my-1"},{default:s(()=>[t(w,{cols:"12"},{default:s(()=>[t(de,{clearable:!0,modelValue:o(M),"onUpdate:modelValue":l[0]||(l[0]=e=>b(M)?M.value=e:null),placeholder:"Search","prepend-inner-icon":"ri-search-line",variant:"solo","onClick:clear":o(G),onInput:o(G)},null,8,["modelValue","onClick:clear","onInput"])]),_:1}),t(w,{cols:"12"},{default:s(()=>[t(P,{clearable:!0,loading:o(r),disabled:o(r),label:"Package Name",items:o(W),"item-title":e=>e.package?e.type_of+" - "+e.package:e.type_of,"item-value":"id",modelValue:o(F),"onUpdate:modelValue":[l[1]||(l[1]=e=>b(F)?F.value=e:null),g],placeholder:"Select Timesheet Package",variant:"solo"},null,8,["loading","disabled","items","item-title","modelValue"])]),_:1}),t(w,{cols:"12"},{default:s(()=>[t(P,{loading:o(r),disabled:o(r),clearable:"true",label:"Tutor/Mentor Name",items:o(X),"item-props":e=>({title:e.full_name,subtitle:e.roles.map(p=>p.name).join(", ")}),"item-value":"id",modelValue:o(U),"onUpdate:modelValue":[l[2]||(l[2]=e=>b(U)?U.value=e:null),g],placeholder:"Select Tutor/Mentor Name",variant:"solo"},null,8,["loading","disabled","items","item-props","modelValue"])]),_:1}),t(w,{cols:"12"},{default:s(()=>[t(c,{modelValue:o(h),"onUpdate:modelValue":[l[3]||(l[3]=e=>b(h)?h.value=e:null),g],label:"Cut-Off Date","prepend-icon":"",multiple:"range",color:"primary",variant:"solo",clearable:!0},null,8,["modelValue"])]),_:1})]),_:1})]),_:1},8,["active"]),t(we,{modelValue:o(m),"onUpdate:modelValue":l[9]||(l[9]=e=>b(m)?m.value=e:null),width:"auto"},{default:s(()=>[t(E,{width:"450","prepend-icon":"ri-download-line",title:"Download Timesheet"},{default:s(()=>[t(z,null,{default:s(()=>[t(ke,{onSubmit:pe(ne,["prevent"]),ref_key:"formData",ref:A},{default:s(()=>[t(B,null,{default:s(()=>[t(w,{cols:"12"},{default:s(()=>[t(c,{label:"Start - End Date",variant:"solo","prepend-icon":"",multiple:"range",modelValue:o(i).cut_off_date,"onUpdate:modelValue":[l[5]||(l[5]=e=>o(i).cut_off_date=e),oe],rules:o(ye).required,class:"mb-3"},null,8,["modelValue","rules"]),t(ee,{label:"Specific Timesheet",modelValue:o(i).specific,"onUpdate:modelValue":l[6]||(l[6]=e=>o(i).specific=e)},null,8,["modelValue"]),t(P,{loading:o(r),label:"Timesheet - Package",variant:"solo",items:o(Z),"item-props":e=>({title:e.package_type+" - "+e.package_name,subtitle:e.clients}),"item-value":"id",class:"mt-3",modelValue:o(i).timesheet_id,"onUpdate:modelValue":l[7]||(l[7]=e=>o(i).timesheet_id=e),disabled:!o(i).specific},null,8,["loading","items","item-props","modelValue","disabled"])]),_:1})]),_:1}),t(Ve,{class:"mt-5"},{default:s(()=>[t($,{color:"error",onClick:l[8]||(l[8]=e=>m.value=!1)},{default:s(()=>[t(C,{icon:"ri-close-line",class:"me-3"}),Y(" Close ")]),_:1}),t(fe),t($,{color:"success",type:"submit"},{default:s(()=>[Y(" Download "),t(C,{icon:"ri-download-line",class:"ms-3"})]),_:1})]),_:1})]),_:1},512)]),_:1})]),_:1})]),_:1},8,["modelValue"]),t(E,null,{default:s(()=>[t(ge,null,{default:s(()=>[Ue]),_:1}),t(z,null,{default:s(()=>[t(B,{class:"my-1"},{default:s(()=>[t(w,{cols:"6"},{default:s(()=>[j((v(),I($,{color:"info",onClick:l[10]||(l[10]=e=>T.value=!o(T))},{default:s(()=>[t(C,{icon:"ri-search-line"})]),_:1})),[[L,"Filter","end"]])]),_:1}),t(w,{cols:"6",class:"text-end"},{default:s(()=>[o(x).length>0?j((v(),I($,{key:0,color:"error",class:"me-1",onClick:le},{default:s(()=>[t(C,{icon:"ri-close-line"})]),_:1})),[[L,"Cancel","start"]]):Q("",!0),j((v(),I($,{color:"secondary",onClick:l[11]||(l[11]=e=>m.value=!0)},{default:s(()=>[t(C,{icon:"ri-download-line"})]),_:1})),[[L,"Download Timesheet","start"]])]),_:1})]),_:1}),o(r)?(v(),I(Ce,{key:0,class:"mx-auto border",type:"table-thead, table-row@10"})):(v(),I(De,{key:1,class:"text-no-wrap"},{default:s(()=>{var e,p;return[Ne,a("tbody",null,[(v(!0),O(K,null,me(o(V).data,u=>(v(),O("tr",{key:u},[a("td",null,[t(ee,{modelValue:o(x),"onUpdate:modelValue":l[12]||(l[12]=y=>b(x)?x.value=y:null),value:u.id},null,8,["modelValue","value"])]),a("td",null,f(u.package.type+" - "+u.package.name),1),a("td",null,f(u.activity),1),a("td",null,f(u.students),1),a("td",null,f(u.date),1),a("td",null,f(u.mentor_tutor),1),a("td",null,f(u.time_spent>0?(u.time_spent/60).toFixed(2)+" Hours":"-"),1),a("td",null,"Rp. "+f(new Intl.NumberFormat("id-ID").format(u.fee_hours)),1),a("td",null,"Rp. "+f(new Intl.NumberFormat("id-ID").format(u.time_spent/60*u.fee_hours)),1),a("td",$e,f(u.cutoff_date),1),a("td",Ie,[t(xe,{color:"success"},{default:s(()=>[Y(f(u.cutoff_status),1)]),_:2},1024)])]))),128))]),a("thead",null,[a("tr",null,[Oe,a("th",Ae," Rp. "+f(new Intl.NumberFormat("id-ID").format(o(V).total_fee)),1)])]),((p=(e=o(V))==null?void 0:e.data)==null?void 0:p.length)==0?(v(),O("tfoot",Re,Be)):Q("",!0)]}),_:1})),a("div",Pe,[t(Ye,{modelValue:o(S),"onUpdate:modelValue":[l[13]||(l[13]=e=>b(S)?S.value=e:null),g],length:o(q),"total-visible":4,color:"primary",density:"compact","show-first-last-page":!1},null,8,["modelValue","length"])])]),_:1})]),_:1})],64)}}};export{it as default};
========
import{o as v,c as O,a,d as J,b as t,V as C,w as s,u as o,n as re,a5 as ue,j as Y,r as d,e as ie,z as b,F as K,v as k,A as D,l as ce,W as de,Z as pe,Y as $,m as fe,x as j,f as I,h as Q,X as me,t as f,a0 as ve,s as R,a2 as _e,a3 as he}from"./main-Dnhd_iiv.js";import{r as ye}from"./rules-B5G8qOzK.js";import{a as z,V as E,c as Ve,b as ge}from"./VCard-6WMyhEEp.js";import{d as be}from"./debounce-CuqlUFN-.js";import{V as we}from"./VDialog-C0DcI_Hy.js";import{V as B,a as w}from"./VRow-CFrvXSoG.js";import{V as P,a as xe}from"./VAutocomplete-DLunx94d.js";import{V as ke}from"./VForm-Da5loNqd.js";import{V as ee}from"./VCheckbox-qMK5vf1-.js";import{a as De,V as Ce}from"./VTable-DArGt7OT.js";import{V as Ye}from"./VPagination-C3yV3swF.js";import{T as L}from"./index-BOl06sSM.js";import"./VAvatar-CImEaqiH.js";import"./VImg-CehDLjIH.js";import"./VList-BOUyf6ft.js";import"./ssrBoot-BaSUV1Gb.js";import"./VDivider-BanKfq9l.js";import"./VCheckboxBtn-BEGrTcPQ.js";import"./VSelectionControl-B9N-6ZOt.js";import"./VSlideGroup-BITq65FJ.js";import"./VTooltip-DWsxbR8-.js";const Te={class:"position-relative overflow-hidden"},Se={class:"d-flex justify-space-between"},Me={class:"text-secondary"},Fe={__name:"FilterSidebar",props:{active:Boolean,width:Number},emits:["close"],setup(H,{emit:r}){const V=H,A=r;return(m,i)=>(v(),O("section",Te,[a("div",{class:re(["position-fixed filter-content",V.active?"active":""]),style:ue({width:V.width+"px"})},[a("div",Se,[a("h3",Me,[J(m.$slots,"header",{},()=>[Y("Title")])]),a("div",{onClick:i[0]||(i[0]=T=>A("close"))},[t(C,{icon:"ri-close-line",color:"#e08282",class:"cursor-pointer"})])]),t(o(E),{class:"mt-3"},{default:s(()=>[t(o(z),null,{default:s(()=>[J(m.$slots,"content",{},()=>[Y("Content")])]),_:3})]),_:3})],6)]))}},Ue=a("div",{class:"d-flex justify-between align-center"},[a("div",{class:"w-100"},[a("h4",null,"Completed Cut-Off")])],-1),Ne=a("thead",null,[a("tr",null,[a("th",{class:"text-uppercase"},"#"),a("th",{class:"text-uppercase text-center"},"Timesheet"),a("th",{class:"text-uppercase text-center"},"Activity"),a("th",{class:"text-uppercase text-center"},"Students Name"),a("th",{class:"text-uppercase text-center"},"Activity Date"),a("th",{class:"text-uppercase text-center"},"Mentor/Tutor"),a("th",{class:"text-uppercase text-center"},"Time Spent"),a("th",{class:"text-uppercase text-center"},"Fee/Hours"),a("th",{class:"text-uppercase text-center"},"Total"),a("th",{class:"text-uppercase text-center"},"Cut-Off Date"),a("th",{class:"text-uppercase text-center"},"Cut-Off Status")])],-1),$e={class:"text-center"},Ie={class:"text-center text-capitalize"},Oe=a("th",{colspan:"9"},"Total Fee",-1),Ae={colspan:"2",class:"text-end"},Re={key:0},je=a("tr",null,[a("td",{colspan:"10",class:"text-center"}," Sorry, no data found. ")],-1),Be=[je],Pe={class:"d-flex justify-center mt-5"},it={__name:"completed",setup(H){const r=d(!1),V=d([]),A=d(),m=d(!1),i=d({cut_off_date:[],specific:!1,timesheet_id:null}),T=d(!1),S=d(1),q=d(),x=d([]),M=d(null),F=d(null),W=d([]),U=d(null),X=d([]),Z=d([]),h=d(null),g=async()=>{r.value=!0;const n="?page="+S.value,l=M.value?"&keyword="+M.value:"",c=F.value?"&package_id="+F.value:"",e=h.value?"&cutoff_start="+k(h.value[0]).format("YYYY-MM-DD"):"",p=h.value?"&cutoff_end="+k(h.value[h.value.length-1]).format("YYYY-MM-DD"):"",u=U.value?"&mentor_id="+U.value:"",y="api/v1/payment/paid"+n+l+c+e+p+u;try{const _=await D.get(y);_&&(S.value=_.current_page,q.value=_.last_page,V.value=_)}catch(_){console.error(_)}finally{r.value=!1}},G=be(async()=>{await g()},1e3),te=async()=>{r.value=!0;try{const n=await D.get("api/v1/package/component/list");n&&(W.value=n,r.value=!1)}catch(n){r.value=!1,console.error(n)}},ae=async()=>{r.value=!0;try{const n=await D.get("api/v1/user/mentor-tutors");n&&(X.value=n,r.value=!1)}catch(n){r.value=!1,console.error(n)}},le=async()=>{const n=await ve("Are you sure you want to cancel this activity?"),l={activity_id:Object.keys(x.value).map(c=>x.value[c])};if(n){r.value=!0;try{const c=await D.patch("api/v1/payment/cut-off/unassign",l);c&&(R("success",c.message,"bottom-end"),g())}catch(c){R("error",c.response.statusText,"bottom-end")}finally{r.value=!1}}},oe=async()=>{let n=i.value.cut_off_date,l=k(n[0]).format("YYYY-MM-DD"),c=k(n[n.length-1]).format("YYYY-MM-DD");const e="api/v1/timesheet/component/list?cutoff_start="+l+"&cutoff_end="+c;r.value=!0;try{const p=await D.get(e);p&&(Z.value=p,r.value=!1)}catch(p){r.value=!1,console.error(p)}},se=()=>{i.value.cut_off_date=[],i.value.specific=!1,i.value.timesheet_id=null},ne=async()=>{let n=i.value.cut_off_date,l=k(n[0]).format("YYYY-MM-DD"),c=k(n[n.length-1]).format("YYYY-MM-DD"),p="api/v1/payment/cut-off/export"+(i.value.specific?"/"+i.value.timesheet_id:"")+"/"+l+"/"+c;const{valid:u}=await A.value.validate();if(u){m.value=!1,_e();try{const y=await D.get(p,{responseType:"blob"});if(y){const _=window.URL.createObjectURL(new Blob([y],{type:'"application/vnd.openxmlformats-officedocument.spreadsheetml.sheet"'})),N=document.createElement("a");N.href=_,N.setAttribute("download",`payroll_${l}_${c}.xlsx`),document.body.appendChild(N),N.click(),document.body.removeChild(N),window.URL.revokeObjectURL(_),he.close(),R("success","Successfully downloaded","bottom-end")}}catch(y){m.value=!0,R("error","Cut-Off date is not found!","bottom-end"),console.log(y)}finally{se()}}};return ie(()=>{g(),te(),ae()}),(n,l)=>{const c=ce("VDateInput");return v(),O(K,null,[t(Fe,{active:o(T),width:450,onClose:l[4]||(l[4]=e=>T.value=!1)},{header:s(()=>[Y(" Filter ")]),content:s(()=>[t(B,{class:"my-1"},{default:s(()=>[t(w,{cols:"12"},{default:s(()=>[t(de,{clearable:!0,modelValue:o(M),"onUpdate:modelValue":l[0]||(l[0]=e=>b(M)?M.value=e:null),placeholder:"Search","prepend-inner-icon":"ri-search-line",variant:"solo","onClick:clear":o(G),onInput:o(G)},null,8,["modelValue","onClick:clear","onInput"])]),_:1}),t(w,{cols:"12"},{default:s(()=>[t(P,{clearable:!0,loading:o(r),disabled:o(r),label:"Package Name",items:o(W),"item-title":e=>e.package?e.type_of+" - "+e.package:e.type_of,"item-value":"id",modelValue:o(F),"onUpdate:modelValue":[l[1]||(l[1]=e=>b(F)?F.value=e:null),g],placeholder:"Select Timesheet Package",variant:"solo"},null,8,["loading","disabled","items","item-title","modelValue"])]),_:1}),t(w,{cols:"12"},{default:s(()=>[t(P,{loading:o(r),disabled:o(r),clearable:"true",label:"Tutor/Mentor Name",items:o(X),"item-props":e=>({title:e.full_name,subtitle:e.roles.map(p=>p.name).join(", ")}),"item-value":"id",modelValue:o(U),"onUpdate:modelValue":[l[2]||(l[2]=e=>b(U)?U.value=e:null),g],placeholder:"Select Tutor/Mentor Name",variant:"solo"},null,8,["loading","disabled","items","item-props","modelValue"])]),_:1}),t(w,{cols:"12"},{default:s(()=>[t(c,{modelValue:o(h),"onUpdate:modelValue":[l[3]||(l[3]=e=>b(h)?h.value=e:null),g],label:"Cut-Off Date","prepend-icon":"",multiple:"range",color:"primary",variant:"solo",clearable:!0},null,8,["modelValue"])]),_:1})]),_:1})]),_:1},8,["active"]),t(we,{modelValue:o(m),"onUpdate:modelValue":l[9]||(l[9]=e=>b(m)?m.value=e:null),width:"auto"},{default:s(()=>[t(E,{width:"450","prepend-icon":"ri-download-line",title:"Download Timesheet"},{default:s(()=>[t(z,null,{default:s(()=>[t(ke,{onSubmit:pe(ne,["prevent"]),ref_key:"formData",ref:A},{default:s(()=>[t(B,null,{default:s(()=>[t(w,{cols:"12"},{default:s(()=>[t(c,{label:"Start - End Date",variant:"solo","prepend-icon":"",multiple:"range",modelValue:o(i).cut_off_date,"onUpdate:modelValue":[l[5]||(l[5]=e=>o(i).cut_off_date=e),oe],rules:o(ye).required,class:"mb-3"},null,8,["modelValue","rules"]),t(ee,{label:"Specific Timesheet",modelValue:o(i).specific,"onUpdate:modelValue":l[6]||(l[6]=e=>o(i).specific=e)},null,8,["modelValue"]),t(P,{loading:o(r),label:"Timesheet - Package",variant:"solo",items:o(Z),"item-props":e=>({title:e.package_type+" - "+e.package_name,subtitle:e.clients}),"item-value":"id",class:"mt-3",modelValue:o(i).timesheet_id,"onUpdate:modelValue":l[7]||(l[7]=e=>o(i).timesheet_id=e),disabled:!o(i).specific},null,8,["loading","items","item-props","modelValue","disabled"])]),_:1})]),_:1}),t(Ve,{class:"mt-5"},{default:s(()=>[t($,{color:"error",onClick:l[8]||(l[8]=e=>m.value=!1)},{default:s(()=>[t(C,{icon:"ri-close-line",class:"me-3"}),Y(" Close ")]),_:1}),t(fe),t($,{color:"success",type:"submit"},{default:s(()=>[Y(" Download "),t(C,{icon:"ri-download-line",class:"ms-3"})]),_:1})]),_:1})]),_:1},512)]),_:1})]),_:1})]),_:1},8,["modelValue"]),t(E,null,{default:s(()=>[t(ge,null,{default:s(()=>[Ue]),_:1}),t(z,null,{default:s(()=>[t(B,{class:"my-1"},{default:s(()=>[t(w,{cols:"6"},{default:s(()=>[j((v(),I($,{color:"info",onClick:l[10]||(l[10]=e=>T.value=!o(T))},{default:s(()=>[t(C,{icon:"ri-search-line"})]),_:1})),[[L,"Filter","end"]])]),_:1}),t(w,{cols:"6",class:"text-end"},{default:s(()=>[o(x).length>0?j((v(),I($,{key:0,color:"error",class:"me-1",onClick:le},{default:s(()=>[t(C,{icon:"ri-close-line"})]),_:1})),[[L,"Cancel","start"]]):Q("",!0),j((v(),I($,{color:"secondary",onClick:l[11]||(l[11]=e=>m.value=!0)},{default:s(()=>[t(C,{icon:"ri-download-line"})]),_:1})),[[L,"Download Timesheet","start"]])]),_:1})]),_:1}),o(r)?(v(),I(Ce,{key:0,class:"mx-auto border",type:"table-thead, table-row@10"})):(v(),I(De,{key:1,class:"text-no-wrap"},{default:s(()=>{var e,p;return[Ne,a("tbody",null,[(v(!0),O(K,null,me(o(V).data,u=>(v(),O("tr",{key:u},[a("td",null,[t(ee,{modelValue:o(x),"onUpdate:modelValue":l[12]||(l[12]=y=>b(x)?x.value=y:null),value:u.id},null,8,["modelValue","value"])]),a("td",null,f(u.package.type+" - "+u.package.name),1),a("td",null,f(u.activity),1),a("td",null,f(u.students),1),a("td",null,f(u.date),1),a("td",null,f(u.mentor_tutor),1),a("td",null,f(u.time_spent>0?(u.time_spent/60).toFixed(2)+" Hours":"-"),1),a("td",null,"Rp. "+f(new Intl.NumberFormat("id-ID").format(u.fee_hours)),1),a("td",null,"Rp. "+f(new Intl.NumberFormat("id-ID").format(u.time_spent/60*u.fee_hours)),1),a("td",$e,f(u.cutoff_date),1),a("td",Ie,[t(xe,{color:"success"},{default:s(()=>[Y(f(u.cutoff_status),1)]),_:2},1024)])]))),128))]),a("thead",null,[a("tr",null,[Oe,a("th",Ae," Rp. "+f(new Intl.NumberFormat("id-ID").format(o(V).total_fee)),1)])]),((p=(e=o(V))==null?void 0:e.data)==null?void 0:p.length)==0?(v(),O("tfoot",Re,Be)):Q("",!0)]}),_:1})),a("div",Pe,[t(Ye,{modelValue:o(S),"onUpdate:modelValue":[l[13]||(l[13]=e=>b(S)?S.value=e:null),g],length:o(q),"total-visible":4,color:"primary",density:"compact","show-first-last-page":!1},null,8,["modelValue","length"])])]),_:1})]),_:1})],64)}}};export{it as default};
>>>>>>>> origin/production:public/build/assets/completed-CqVq_asn.js
