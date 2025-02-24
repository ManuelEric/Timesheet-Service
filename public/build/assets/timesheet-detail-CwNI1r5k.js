import{r as w,l as R,o as _,f as T,w as s,b as t,Z as ee,W as z,u as l,v as E,Y,V as y,j as k,m as te,A as N,s as M,$ as I,e as X,a as e,x as L,h as H,c as S,X as Z,F as K,t as u,y as le,a1 as se,k as Q,a4 as J}from"./main-DV4WMWdJ.js";import{_ as ae}from"./DeleteHandler.vue_vue_type_script_setup_true_lang-C9PkjZ9F.js";import{d as oe}from"./debounce-CQTSfoj2.js";import{r as q}from"./rules-B5G8qOzK.js";import{a as C,c as ie,V as P,b as U,d as F}from"./VCard-T6Nf0MsR.js";import{V as ne}from"./VForm-dcUZ5jCO.js";import{V as O,a as D}from"./VRow-B0y8aIlI.js";import{V as de}from"./VTextarea-DA84tI37.js";import{V as W}from"./VDialog-DwREO28q.js";import{a as G,V as B}from"./VTable-fUVhvM40.js";import{T as j}from"./index-C9ZJiS2c.js";import{V as re}from"./VCheckbox-DeAklfQn.js";import"./VAvatar-CxdFL0bp.js";import"./VImg-BTe1y1ho.js";import"./VTooltip-D_cSrZZA.js";import"./VCheckboxBtn-BWOcWpBv.js";import"./VSelectionControl-VSCYL-IM.js";const ce={__name:"activity-add",props:{id:String},emits:["close","reload"],setup(A,{emit:h}){const b=A,g=h,c=w(!1),p=w(),a=w({activity:null,description:null,date:null,start_time:null,end_time:null,start_date:null,end_date:null,meeting_link:null}),f=async()=>{var r,V;const{valid:v}=await p.value.validate();if(v){c.value=!0;try{const m=await N.post("api/v1/timesheet/"+b.id+"/activity",a.value);m&&M("success",m.message,"bottom-end")}catch(m){if((V=(r=m==null?void 0:m.response)==null?void 0:r.data)!=null&&V.errors){const i=m.response.data.errors;let o="Validation errors:";for(const n in i)i.hasOwnProperty(n)&&(o+=`
${n}: ${i[n].join(", ")}`);M("error",o,"bottom-end")}else M("error",m.response.data.message,"bottom-end")}finally{c.value=!1,g("reload"),g("close")}}};return(v,r)=>{const V=R("DialogCloseBtn"),m=R("VDateInput");return _(),T(P,{title:"New Activity"},{default:s(()=>[t(V,{variant:"text",size:"default",onClick:r[0]||(r[0]=i=>g("close"))}),t(C,null,{default:s(()=>[t(ne,{onSubmit:ee(f,["prevent"]),ref_key:"formData",ref:p,"validate-on":"input"},{default:s(()=>[t(O,null,{default:s(()=>[t(D,{cols:"12",class:"d-none"},{default:s(()=>[t(z,{modelValue:l(a).activity,"onUpdate:modelValue":r[1]||(r[1]=i=>l(a).activity=i),label:"Activity Name",placeholder:"Activity",loading:l(c),disabled:l(c),variant:"solo"},null,8,["modelValue","loading","disabled"])]),_:1}),t(D,{cols:"12"},{default:s(()=>[t(de,{modelValue:l(a).description,"onUpdate:modelValue":r[2]||(r[2]=i=>l(a).description=i),label:"Meeting Discussion",placeholder:"Meeting Discussion",variant:"solo",loading:l(c),disabled:l(c),rules:l(q).required},null,8,["modelValue","loading","disabled","rules"])]),_:1}),t(D,{md:"6",cols:"12"},{default:s(()=>[t(m,{modelValue:l(a).date,"onUpdate:modelValue":r[3]||(r[3]=i=>l(a).date=i),label:"Date",placeholder:"Select Date","prepend-icon":"",variant:"solo",loading:l(c),disabled:l(c),rules:l(q).required},null,8,["modelValue","loading","disabled","rules"])]),_:1}),t(D,{md:"3",cols:"6"},{default:s(()=>[t(z,{type:"time",modelValue:l(a).start_time,"onUpdate:modelValue":r[4]||(r[4]=i=>l(a).start_time=i),label:"Start Time",placeholder:"Start Time",rules:l(q).required,variant:"solo",class:"mb-3",loading:l(c),disabled:l(c),onChange:r[5]||(r[5]=i=>l(a).start_date=l(E)(l(a).date).format("YYYY-MM-DD")+" "+l(a).start_time+":00")},null,8,["modelValue","rules","loading","disabled"])]),_:1}),t(D,{md:"3",cols:"6"},{default:s(()=>[t(z,{type:"time",modelValue:l(a).end_time,"onUpdate:modelValue":r[6]||(r[6]=i=>l(a).end_time=i),label:"End Time",placeholder:"End Time",variant:"solo",loading:l(c),disabled:l(c),onChange:r[7]||(r[7]=i=>l(a).end_date=l(E)(l(a).date).format("YYYY-MM-DD")+" "+l(a).end_time+":00")},null,8,["modelValue","loading","disabled"])]),_:1}),t(D,{md:"12",cols:"12"},{default:s(()=>[t(z,{type:"text",modelValue:l(a).meeting_link,"onUpdate:modelValue":r[8]||(r[8]=i=>l(a).meeting_link=i),label:"Meeting Link",placeholder:"Meeting Link",variant:"solo",loading:l(c),disabled:l(c)},null,8,["modelValue","loading","disabled"])]),_:1})]),_:1}),t(ie,{class:"mt-5"},{default:s(()=>[t(Y,{type:"button",color:"error",loading:l(c),disabled:l(c),onClick:r[9]||(r[9]=i=>g("close"))},{default:s(()=>[t(y,{icon:"ri-close-line",class:"me-3"}),k(" Close ")]),_:1},8,["loading","disabled"]),t(te),t(Y,{loading:l(c),disabled:l(c),type:"submit",color:"success"},{default:s(()=>[k(" Save "),t(y,{icon:"ri-save-line",class:"ms-3"})]),_:1},8,["loading","disabled"])]),_:1})]),_:1},512)]),_:1})]),_:1})}}},ue={class:"d-flex justify-between align-center"},me=e("div",{class:"w-100"},[e("h4",null,"Activity")],-1),_e=e("thead",null,[e("tr",null,[e("th",{class:"text-uppercase",width:"1%"}," No "),e("th",{class:"text-uppercase text-center"},"Meeting Discussion"),e("th",{class:"text-uppercase text-center"},"Date"),e("th",{class:"text-uppercase text-center"},"Start Time"),e("th",{class:"text-uppercase text-center",style:{width:"200px !important"}}," End Time "),e("th",{class:"text-uppercase text-center"},"Time Spent"),e("th",{class:"text-uppercase text-center"},"Status"),e("th",{class:"text-uppercase text-end"},"#")])],-1),pe={width:"1%"},fe={class:"text-start"},he={class:"text-center"},ge={class:"text-start"},ve=["onUpdate:modelValue","onChange","disabled"],ye={class:"text-center"},be={class:"text-end"},xe=["href"],we={__name:"timesheet-detail",props:{id:String,require:String},setup(A){const h=A,b=I("updateReload"),g=w([]),c=w(!1),p=w([{add:!1,delete:!1}]),a=w([]),f=async()=>{c.value=!0;try{const o=await N.get("api/v1/timesheet/"+h.id+"/activities");o&&(g.value=o)}catch(o){console.error(o)}finally{c.value=!1}},v=o=>{p.value[o]?p.value[o]=!1:p.value[o]=!0},r=(o,n)=>{a.value=n,v(o)},V=async()=>{var o,n,d;try{const x=await N.delete("api/v1/timesheet/"+h.id+"/activity/"+a.value.id);x&&(M("success",x.message,"bottom-end"),v("delete"))}catch(x){((o=x.response)==null?void 0:o.status)==400&&M("error",(d=(n=x.response)==null?void 0:n.data)==null?void 0:d.errors,"bottom-end")}finally{f(),b(!0)}},m=oe(async o=>{o.end_date=o.date+" "+o.end_time+":00";try{const n=await N.put("api/v1/timesheet/"+h.id+"/activity/"+o.id,o);n&&M("success",n.message,"bottom-end")}catch(n){console.error(n)}finally{f(),b(!0)}},500),i=async o=>{try{const n=await N.put("api/v1/timesheet/"+h.id+"/activity/"+o.id,o);n&&M("success",n.message,"bottom-end")}catch(n){console.error(n)}finally{f(),b(!0)}};return X(()=>{f()}),(o,n)=>(_(),T(P,null,{default:s(()=>[t(U,null,{default:s(()=>[e("div",ue,[me,h.require=="mentor"?L((_(),T(Y,{key:0,onClick:n[0]||(n[0]=d=>v("add"))},{default:s(()=>[t(y,{icon:"ri-add-line"})]),_:1})),[[j,"New Activity","start"]]):H("",!0),t(W,{modelValue:l(p).add,"onUpdate:modelValue":n[2]||(n[2]=d=>l(p).add=d),"max-width":"600",persistent:""},{default:s(()=>[t(ce,{id:h.id,onClose:n[1]||(n[1]=d=>v("add")),onReload:f},null,8,["id"])]),_:1},8,["modelValue"])])]),_:1}),t(C,null,{default:s(()=>[l(c)?(_(),T(B,{key:1,type:"table"})):(_(),T(G,{key:0,class:"text-no-wrap",height:"400","fixed-header":""},{default:s(()=>[_e,e("tbody",null,[(_(!0),S(K,null,Z(l(g),(d,x)=>(_(),S("tr",{key:x},[e("td",pe,u(x+1),1),e("td",fe,u(d.description),1),e("td",null,u(o.$moment(d.start_date).format("dddd"))+", "+u(o.$moment(d.start_date).format("MMM Do YYYY")),1),e("td",he,u(d.start_time),1),e("td",ge,[L(e("input",{type:"time",class:"form-control px-2 py-2 border rounded cursor-pointer","onUpdate:modelValue":$=>d.end_time=$,onChange:$=>l(m)(d),disabled:d.start_time=="00:00"||d.cutoff_status=="completed"},null,40,ve),[[le,d.end_time],[j,d.cutoff_status=="completed"?"Already Cut-Off":"End Time","start"]])]),e("td",ye,u(d.estimate)+" Minutes",1),e("td",null,[L(t(re,{color:"success",modelValue:d.status,"onUpdate:modelValue":[$=>d.status=$,$=>i(d)],value:!0,"false-value":0,disabled:d.start_time=="00:00"||d.cutoff_status=="completed"},null,8,["modelValue","onUpdate:modelValue","disabled"]),[[j,d.status?"Completed":"Not Yet","start"]])]),e("td",be,[t(Y,{color:"primary",density:"compact",class:"me-1"},{default:s(()=>[e("a",{href:d.meeting_link,target:"_blank",class:"bg-primary"},[t(y,{icon:"ri ri-link"}),k(" Join ")],8,xe)]),_:2},1024),L((_(),T(Y,{color:"error",density:"compact",disabled:d.start_time=="00:00"||d.cutoff_status=="completed",onClick:$=>r("delete",d)},{default:s(()=>[t(y,{icon:"ri-delete-bin-line",class:"cursor-pointer"})]),_:2},1032,["disabled","onClick"])),[[j,d.status?"Already Cut-Off":"Delete Activity","start"]])])]))),128))])]),_:1}))]),_:1}),t(W,{modelValue:l(p).delete,"onUpdate:modelValue":n[4]||(n[4]=d=>l(p).delete=d),"max-width":"400",persistent:""},{default:s(()=>[t(ae,{title:"activity",onClose:n[3]||(n[3]=d=>v("delete")),onDelete:V})]),_:1},8,["modelValue"])]),_:1}))}},Ve={class:"w-100"},ke={class:"mt-3 font-weight-light"},De=e("hr",{class:"my-2"},null,-1),$e={key:0},Ce=e("tr",{class:"bg-secondary"},[e("td",null,"Name"),e("td",null,"School"),e("td",null,"Grade")],-1),Te={key:1},Me=e("td",{width:"20%"},"Name",-1),Se=e("td",{width:"1%"},":",-1),Ae=e("td",null,"School Name",-1),Ne=e("td",{width:"1%"},":",-1),Pe=e("td",null,"Grade",-1),Ye=e("td",{width:"1%"},":",-1),Ue=e("td",null,"Email",-1),Be=e("td",{width:"1%"},":",-1),ze={class:"mt-5 font-weight-light"},Le=e("hr",{class:"my-2"},null,-1),je=e("td",{width:"20%"},"Program",-1),qe=e("td",{width:"1%"},":",-1),Fe=e("td",null,"Package",-1),Re=e("td",{width:"1%"},":",-1),Ee=e("td",null,"Person in Charge",-1),Ie=e("td",{width:"1%"},":",-1),Oe={class:"ms-4",type:"1"},Ge=e("td",null,"Tutor/Mentor",-1),He=e("td",{width:"1%"},":",-1),Je=e("td",null,"Update On",-1),We=e("td",{width:"1%"},":",-1),Xe={class:"d-flex align-end w-100"},Ze={class:"m-0 mb-1 text-white"},Ke=e("h4",{class:"m-0 ms-2 text-white"},"Minutes",-1),Qe={class:"text-end w-100"},et={class:"d-flex align-end w-100"},tt={class:"m-0 mb-1 text-white"},lt=e("h4",{class:"m-0 ms-2 text-white"},"Minutes",-1),st={class:"text-end w-100"},at={class:"d-flex align-end w-100"},ot={class:"m-0 mb-1 text-white"},it=e("h4",{class:"m-0 ms-2 text-white"},"Minutes",-1),nt={class:"text-end w-100"},dt={__name:"user-detail",props:{id:String},emits:["void"],setup(A,{emit:h}){const b=A,g=h,c=I("reloadData"),p=I("updateReload"),a=w([]),f=w(!1),v=async r=>{var V,m,i;f.value=!0;try{const o=await N.get("api/v1/timesheet/"+r+"/detail");o&&(a.value=o,g("void",o.packageDetails.void))}catch(o){((V=o.response)==null?void 0:V.status)==400&&(M("error",(i=(m=o.response)==null?void 0:m.data)==null?void 0:i.errors,"bottom-end"),Q.push("/admin/timesheet")),console.log(o)}finally{f.value=!1}};return X(()=>{v(b.id)}),se(()=>{c.value&&(v(b.id),p(!1))}),(r,V)=>{const m=R("router-link");return _(),T(P,{class:"mb-3"},{default:s(()=>[t(U,{class:"d-flex justify-between align-center"},{default:s(()=>{var i;return[e("div",Ve,[t(m,{to:"/user/timesheet"},{default:s(()=>[t(y,{icon:"ri-arrow-left-line",color:"secondary",class:"me-2",size:"25"})]),_:1}),k(" Timesheet - "+u((i=l(a).packageDetails)==null?void 0:i.package_type),1)])]}),_:1}),t(C,null,{default:s(()=>[l(f)?(_(),T(O,{key:1},{default:s(()=>[t(D,{md:"7"},{default:s(()=>[t(B,{type:"heading, paragraph, heading, paragraph",class:"mb-3"})]),_:1}),t(D,{md:"5"},{default:s(()=>[t(B,{type:"text@3",color:"#16B1FF",class:"mb-3"}),t(B,{type:"text@3",color:"#91c45e",class:"mb-3"}),t(B,{type:"text@3",color:"#e05e5e",class:"mb-3"})]),_:1})]),_:1})):(_(),T(O,{key:0,align:"center"},{default:s(()=>[t(D,{md:"7"},{default:s(()=>[e("h4",ke,[t(y,{icon:"ri-user-line",size:"17",class:"me-2"}),k(" Basic Profile ")]),De,t(G,{density:"compact"},{default:s(()=>{var i,o;return[((i=l(a).clientProfile)==null?void 0:i.length)>1?(_(),S("tbody",$e,[Ce,(_(!0),S(K,null,Z(l(a).clientProfile,n=>(_(),S("tr",null,[e("td",null,u(n.client_name),1),e("td",null,u(n.client_school),1),e("td",null,u(n.client_grade),1)]))),256))])):((o=l(a).clientProfile)==null?void 0:o.length)==1?(_(),S("tbody",Te,[e("tr",null,[Me,Se,e("td",null,u(l(a).clientProfile[0].client_name),1)]),e("tr",null,[Ae,Ne,e("td",null,u(l(a).clientProfile[0].client_school),1)]),e("tr",null,[Pe,Ye,e("td",null,u(l(a).clientProfile[0].client_grade),1)]),e("tr",null,[Ue,Be,e("td",null,u(l(a).clientProfile[0].client_mail),1)])])):H("",!0)]}),_:1}),e("h4",ze,[t(y,{icon:"ri-bookmark-line",class:"me-2",size:"17"}),k(" Package Details ")]),Le,t(G,{density:"compact"},{default:s(()=>{var i,o,n,d,x,$;return[e("tbody",null,[e("tr",null,[je,qe,e("td",null,u((i=l(a).packageDetails)!=null&&i.free_trial?"[TRIAL]":"")+" "+u((o=l(a).packageDetails)==null?void 0:o.program_name),1)]),e("tr",null,[Fe,Re,e("td",null,u(((n=l(a).packageDetails)==null?void 0:n.package_type)+" - "+((d=l(a).packageDetails)==null?void 0:d.package_name)),1)]),e("tr",null,[Ee,Ie,e("td",null,[e("ol",Oe,[e("li",null,u((x=l(a).packageDetails)==null?void 0:x.pic_name),1)])])]),e("tr",null,[Ge,He,e("td",null,u(($=l(a).packageDetails)==null?void 0:$.tutormentor_name),1)]),e("tr",null,[Je,We,e("td",null,u(l(E)().format("LLL")),1)])])]}),_:1})]),_:1}),t(D,{md:"5"},{default:s(()=>[t(P,{color:"#16B1FF",class:"mb-2 d-flex align-center"},{default:s(()=>[e("div",null,[t(F,null,{default:s(()=>[t(U,{class:"text-white"},{default:s(()=>[k(" Total Minutes of Package ")]),_:1})]),_:1}),t(C,{class:"d-flex justify-between"},{default:s(()=>{var i;return[e("div",Xe,[e("h1",Ze,u((i=l(a).packageDetails)==null?void 0:i.duration_in_minutes),1),Ke])]}),_:1})]),t(C,null,{default:s(()=>[e("div",Qe,[t(y,{icon:"ri-calendar-schedule-line",size:"60"})])]),_:1})]),_:1}),t(P,{color:"#91c45e",class:"mb-2 d-flex align-center"},{default:s(()=>[e("div",null,[t(F,null,{default:s(()=>[t(U,{class:"text-white"},{default:s(()=>[k(" Total Minutes Spent ")]),_:1})]),_:1}),t(C,{class:"d-flex justify-between"},{default:s(()=>{var i;return[e("div",et,[e("h1",tt,u((i=l(a).packageDetails)==null?void 0:i.time_spent_in_minutes),1),lt])]}),_:1})]),t(C,null,{default:s(()=>[e("div",st,[t(y,{icon:"ri-timer-flash-line",size:"60",color:"white"})])]),_:1})]),_:1}),t(P,{color:"#e05e5e",class:"mb-2 d-flex align-center"},{default:s(()=>[e("div",null,[t(F,null,{default:s(()=>[t(U,{class:"text-white"},{default:s(()=>[k(" Total Minutes Left ")]),_:1})]),_:1}),t(C,{class:"d-flex justify-between"},{default:s(()=>{var i,o;return[e("div",at,[e("h1",ot,u(((i=l(a).packageDetails)==null?void 0:i.duration_in_minutes)-((o=l(a).packageDetails)==null?void 0:o.time_spent_in_minutes)),1),it])]}),_:1})]),t(C,null,{default:s(()=>[e("div",nt,[t(y,{icon:"ri-timer-2-line",size:"60"})])]),_:1})]),_:1})]),_:1})]),_:1}))]),_:1})]),_:1})}}},rt={class:"h-auto position-relative"},ct={key:0,class:"overlay"},ut=e("div",{class:"bg-secondary",style:{height:"100%",position:"absolute",left:"0",top:"0","z-index":"9998",width:"100%",opacity:"0.6"}},null,-1),mt={class:"d-flex align-center justify-center",style:{height:"100%",position:"absolute",left:"0",top:"0","z-index":"9999",width:"100%",opacity:"1"}},_t={class:"text-center"},pt=e("h2",{class:"text-white mt-3"},"This Timesheet Has Changed Owner",-1),Nt={__name:"timesheet-detail",props:{id:Number,require:String},setup(A){const h=A,b=h.id,g=w(!1),c=w(!1);J("reloadData",g),J("updateReload",a=>{g.value=a});const p=a=>{c.value=a};return(a,f)=>(_(),S("div",rt,[l(c)=="true"?(_(),S("div",ct,[ut,e("div",mt,[e("div",_t,[t(y,{color:"white",icon:"ri-lock-line",size:"50"}),pt,t(Y,{color:"light",class:"mt-4",onClick:f[0]||(f[0]=v=>l(Q).push({path:"/user/timesheet"}))},{default:s(()=>[k(" Back to List ")]),_:1})])])])):H("",!0),t(dt,{id:l(b),onVoid:p},null,8,["id"]),t(we,{id:l(b),require:h.require},null,8,["id","require"])]))}};export{Nt as default};
