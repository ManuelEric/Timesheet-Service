import{o as v,c as O,a,d as K,b as t,V as C,w as s,u as o,n as re,au as ue,j as Y,r as d,an as ie,e as ce,z as w,F as Q,v as k,A as D,l as de,W as pe,am as fe,Y as $,m as me,x as R,f as I,h as Z,X as ve,t as f,aq as _e,s as P,ar as he,as as ye}from"./main-CCxSbBwX.js";import{r as Ve}from"./rules-B5G8qOzK.js";import{a as z,V as E,c as ge,b as we}from"./VCard-BoLn1wH5.js";import{d as be}from"./debounce-BqpS0Q9t.js";import{V as xe}from"./VDialog-B-sJ07wm.js";import{V as j,a as b}from"./VRow-C5xB1PZW.js";import{V as B,a as ke}from"./VAutocomplete-BnglW4wI.js";import{V as De}from"./VForm-CY1asll7.js";import{V as ee}from"./VCheckbox-C3WydO4S.js";import{a as Ce,V as Ye}from"./VTable-DI2V8ZZT.js";import{V as Te}from"./VPagination-3v2BqvHQ.js";import{T as L}from"./index-BBLu0xwI.js";import"./VAvatar-Dudg9Spz.js";import"./VImg-DfdngGeG.js";import"./VList-BB0NWGbU.js";import"./ssrBoot-B0FuLZUD.js";import"./VDivider-DwNWTBcy.js";import"./VCheckboxBtn-CRRpFuSx.js";import"./VSelectionControl-CnqayyH7.js";import"./VSlideGroup-By8vdujR.js";import"./VTooltip-C2aTnrY_.js";const Se={class:"position-relative overflow-hidden"},Me={class:"d-flex justify-space-between"},Fe={class:"text-secondary"},Ue={__name:"FilterSidebar",props:{active:Boolean,width:Number},emits:["close"],setup(q,{emit:r}){const g=q,A=r;return(m,i)=>(v(),O("section",Se,[a("div",{class:re(["position-fixed filter-content",g.active?"active":""]),style:ue({width:g.width+"px"})},[a("div",Me,[a("h3",Fe,[K(m.$slots,"header",{},()=>[Y("Title")])]),a("div",{onClick:i[0]||(i[0]=T=>A("close"))},[t(C,{icon:"ri-close-line",color:"#e08282",class:"cursor-pointer"})])]),t(o(E),{class:"mt-3"},{default:s(()=>[t(o(z),null,{default:s(()=>[K(m.$slots,"content",{},()=>[Y("Content")])]),_:3})]),_:3})],6)]))}},Ne=a("div",{class:"d-flex justify-between align-center"},[a("div",{class:"w-100"},[a("h4",null,"Completed Cut-Off")])],-1),$e=a("thead",null,[a("tr",null,[a("th",{class:"text-uppercase"},"#"),a("th",{class:"text-uppercase text-center"},"Timesheet"),a("th",{class:"text-uppercase text-center"},"Activity"),a("th",{class:"text-uppercase text-center"},"Students Name"),a("th",{class:"text-uppercase text-center"},"Activity Date"),a("th",{class:"text-uppercase text-center"},"Mentor/Tutor"),a("th",{class:"text-uppercase text-center"},"Time Spent"),a("th",{class:"text-uppercase text-center"},"Fee/Hours"),a("th",{class:"text-uppercase text-center"},"Total"),a("th",{class:"text-uppercase text-center"},"Cut-Off Date"),a("th",{class:"text-uppercase text-center"},"Cut-Off Status")])],-1),Ie={class:"text-center"},Oe={class:"text-center text-capitalize"},Ae=a("th",{colspan:"9"},"Total Fee",-1),Pe={colspan:"2",class:"text-end"},Re={key:0},je=a("tr",null,[a("td",{colspan:"10",class:"text-center"}," Sorry, no data found. ")],-1),Be=[je],Le={class:"d-flex justify-center mt-5"},ct={__name:"completed",setup(q){const r=d(!1),g=d([]),A=d(),m=d(!1),i=d({cut_off_date:[],specific:!1,timesheet_id:null}),T=d(!1),S=d(1),H=d(),x=d([]),M=d(null),F=d(null),W=d([]),U=d(null),X=d([]),G=d([]),h=d(null),y=async()=>{r.value=!0;const n="?page="+S.value,l=M.value?"&keyword="+M.value:"",c=F.value?"&package_id="+F.value:"",e=h.value?"&cutoff_start="+k(h.value[0]).format("YYYY-MM-DD"):"",p=h.value?"&cutoff_end="+k(h.value[h.value.length-1]).format("YYYY-MM-DD"):"",u=U.value?"&mentor_id="+U.value:"",V="api/v1/payment/paid"+n+l+c+e+p+u;try{const _=await D.get(V);_&&(S.value=_.current_page,H.value=_.last_page,g.value=_)}catch(_){console.error(_)}finally{r.value=!1}},J=be(async()=>{await y()},1e3),te=async()=>{r.value=!0;try{const n=await D.get("api/v1/package/component/list");n&&(W.value=n,r.value=!1)}catch(n){r.value=!1,console.error(n)}},ae=async()=>{r.value=!0;try{const n=await D.get("api/v1/user/mentor-tutors");n&&(X.value=n,r.value=!1)}catch(n){r.value=!1,console.error(n)}},le=async()=>{const n=await _e("Are you sure you want to cancel this activity?"),l={activity_id:Object.keys(x.value).map(c=>x.value[c])};if(n){r.value=!0;try{const c=await D.patch("api/v1/payment/cut-off/unassign",l);c&&(P("success",c.message,"bottom-end"),y())}catch(c){P("error",c.response.statusText,"bottom-end")}finally{r.value=!1}}},oe=async()=>{let n=i.value.cut_off_date,l=k(n[0]).format("YYYY-MM-DD"),c=k(n[n.length-1]).format("YYYY-MM-DD");const e="api/v1/timesheet/component/list?cutoff_start="+l+"&cutoff_end="+c;r.value=!0;try{const p=await D.get(e);p&&(G.value=p,r.value=!1)}catch(p){r.value=!1,console.error(p)}},se=()=>{i.value.cut_off_date=[],i.value.specific=!1,i.value.timesheet_id=null},ne=async()=>{let n=i.value.cut_off_date,l=k(n[0]).format("YYYY-MM-DD"),c=k(n[n.length-1]).format("YYYY-MM-DD"),p="api/v1/payment/cut-off/export"+(i.value.specific?"/"+i.value.timesheet_id:"")+"/"+l+"/"+c;const{valid:u}=await A.value.validate();if(u){m.value=!1,he();try{const V=await D.get(p,{responseType:"blob"});if(V){const _=window.URL.createObjectURL(new Blob([V],{type:'"application/vnd.openxmlformats-officedocument.spreadsheetml.sheet"'})),N=document.createElement("a");N.href=_,N.setAttribute("download",`Payroll_${l}_${c}.xlsx`),document.body.appendChild(N),N.click(),document.body.removeChild(N),window.URL.revokeObjectURL(_),ye.close(),P("success","Successfully downloaded","bottom-end")}}catch(V){m.value=!0,P("error","Cut-Off date is not found!","bottom-end"),console.log(V)}finally{se()}}};return ie(()=>{y()}),ce(()=>{y(),te(),ae()}),(n,l)=>{const c=de("VDateInput");return v(),O(Q,null,[t(Ue,{active:o(T),width:450,onClose:l[4]||(l[4]=e=>T.value=!1)},{header:s(()=>[Y(" Filter ")]),content:s(()=>[t(j,{class:"my-1"},{default:s(()=>[t(b,{cols:"12"},{default:s(()=>[t(pe,{clearable:!0,modelValue:o(M),"onUpdate:modelValue":l[0]||(l[0]=e=>w(M)?M.value=e:null),placeholder:"Search","prepend-inner-icon":"ri-search-line",variant:"solo","onClick:clear":o(J),onInput:o(J)},null,8,["modelValue","onClick:clear","onInput"])]),_:1}),t(b,{cols:"12"},{default:s(()=>[t(B,{clearable:!0,loading:o(r),disabled:o(r),label:"Package Name",items:o(W),"item-title":e=>e.package?e.type_of+" - "+e.package:e.type_of,"item-value":"id",modelValue:o(F),"onUpdate:modelValue":[l[1]||(l[1]=e=>w(F)?F.value=e:null),y],placeholder:"Select Timesheet Package",variant:"solo"},null,8,["loading","disabled","items","item-title","modelValue"])]),_:1}),t(b,{cols:"12"},{default:s(()=>[t(B,{loading:o(r),disabled:o(r),clearable:"true",label:"Tutor/Mentor Name",items:o(X),"item-props":e=>({title:e.full_name,subtitle:e.roles.map(p=>p.name).join(", ")}),"item-value":"id",modelValue:o(U),"onUpdate:modelValue":[l[2]||(l[2]=e=>w(U)?U.value=e:null),y],placeholder:"Select Tutor/Mentor Name",variant:"solo"},null,8,["loading","disabled","items","item-props","modelValue"])]),_:1}),t(b,{cols:"12"},{default:s(()=>[t(c,{modelValue:o(h),"onUpdate:modelValue":[l[3]||(l[3]=e=>w(h)?h.value=e:null),y],label:"Cut-Off Date","prepend-icon":"",multiple:"range",color:"primary",variant:"solo",clearable:!0},null,8,["modelValue"])]),_:1})]),_:1})]),_:1},8,["active"]),t(xe,{modelValue:o(m),"onUpdate:modelValue":l[9]||(l[9]=e=>w(m)?m.value=e:null),width:"auto"},{default:s(()=>[t(E,{width:"450","prepend-icon":"ri-download-line",title:"Download Timesheet"},{default:s(()=>[t(z,null,{default:s(()=>[t(De,{onSubmit:fe(ne,["prevent"]),ref_key:"formData",ref:A},{default:s(()=>[t(j,null,{default:s(()=>[t(b,{cols:"12"},{default:s(()=>[t(c,{label:"Start - End Date",variant:"solo","prepend-icon":"",multiple:"range",modelValue:o(i).cut_off_date,"onUpdate:modelValue":[l[5]||(l[5]=e=>o(i).cut_off_date=e),oe],rules:o(Ve).required,class:"mb-3"},null,8,["modelValue","rules"]),t(ee,{label:"Specific Timesheet",modelValue:o(i).specific,"onUpdate:modelValue":l[6]||(l[6]=e=>o(i).specific=e)},null,8,["modelValue"]),t(B,{loading:o(r),label:"Timesheet - Package",variant:"solo",items:o(G),"item-props":e=>({title:e.package_type+" - "+e.package_name,subtitle:e.clients}),"item-value":"id",class:"mt-3",modelValue:o(i).timesheet_id,"onUpdate:modelValue":l[7]||(l[7]=e=>o(i).timesheet_id=e),disabled:!o(i).specific},null,8,["loading","items","item-props","modelValue","disabled"])]),_:1})]),_:1}),t(ge,{class:"mt-5"},{default:s(()=>[t($,{color:"error",onClick:l[8]||(l[8]=e=>m.value=!1)},{default:s(()=>[t(C,{icon:"ri-close-line",class:"me-3"}),Y(" Close ")]),_:1}),t(me),t($,{color:"success",type:"submit"},{default:s(()=>[Y(" Download "),t(C,{icon:"ri-download-line",class:"ms-3"})]),_:1})]),_:1})]),_:1},512)]),_:1})]),_:1})]),_:1},8,["modelValue"]),t(E,null,{default:s(()=>[t(we,null,{default:s(()=>[Ne]),_:1}),t(z,null,{default:s(()=>[t(j,{class:"my-1"},{default:s(()=>[t(b,{cols:"6"},{default:s(()=>[R((v(),I($,{color:"info",onClick:l[10]||(l[10]=e=>T.value=!o(T))},{default:s(()=>[t(C,{icon:"ri-search-line"})]),_:1})),[[L,"Filter","end"]])]),_:1}),t(b,{cols:"6",class:"text-end"},{default:s(()=>[o(x).length>0?R((v(),I($,{key:0,color:"error",class:"me-1",onClick:le},{default:s(()=>[t(C,{icon:"ri-close-line"})]),_:1})),[[L,"Cancel","start"]]):Z("",!0),R((v(),I($,{color:"secondary",onClick:l[11]||(l[11]=e=>m.value=!0)},{default:s(()=>[t(C,{icon:"ri-download-line"})]),_:1})),[[L,"Download Timesheet","start"]])]),_:1})]),_:1}),o(r)?(v(),I(Ye,{key:0,class:"mx-auto border",type:"table-thead, table-row@10"})):(v(),I(Ce,{key:1,class:"text-no-wrap"},{default:s(()=>{var e,p;return[$e,a("tbody",null,[(v(!0),O(Q,null,ve(o(g).data,u=>(v(),O("tr",{key:u},[a("td",null,[t(ee,{modelValue:o(x),"onUpdate:modelValue":l[12]||(l[12]=V=>w(x)?x.value=V:null),value:u.id},null,8,["modelValue","value"])]),a("td",null,f(u.package.type+" - "+u.package.name),1),a("td",null,f(u.activity),1),a("td",null,f(u.students),1),a("td",null,f(u.date),1),a("td",null,f(u.mentor_tutor),1),a("td",null,f(u.time_spent>0?(u.time_spent/60).toFixed(2)+" Hours":"-"),1),a("td",null,"Rp. "+f(new Intl.NumberFormat("id-ID").format(u.fee_hours)),1),a("td",null,"Rp. "+f(new Intl.NumberFormat("id-ID").format(u.time_spent/60*u.fee_hours)),1),a("td",Ie,f(u.cutoff_date),1),a("td",Oe,[t(ke,{color:"success"},{default:s(()=>[Y(f(u.cutoff_status),1)]),_:2},1024)])]))),128))]),a("thead",null,[a("tr",null,[Ae,a("th",Pe," Rp. "+f(new Intl.NumberFormat("id-ID").format(o(g).total_fee)),1)])]),((p=(e=o(g))==null?void 0:e.data)==null?void 0:p.length)==0?(v(),O("tfoot",Re,Be)):Z("",!0)]}),_:1})),a("div",Le,[t(Te,{modelValue:o(S),"onUpdate:modelValue":[l[13]||(l[13]=e=>w(S)?S.value=e:null),y],length:o(H),"total-visible":4,color:"primary",density:"compact","show-first-last-page":!1},null,8,["modelValue","length"])])]),_:1})]),_:1})],64)}}};export{ct as default};
