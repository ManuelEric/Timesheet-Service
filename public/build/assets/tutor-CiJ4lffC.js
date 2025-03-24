import{B as le,C as ne,D as re,E as O,G as ie,H as ce,r as x,I as de,K as W,L as ue,M as he,N as me,O as K,b as t,P as $,F as b,Q as fe,R as pe,V as C,S as _e,T as ve,e as we,f as P,w as p,A as E,s as L,o as n,a as e,W as ge,u as w,z as Q,c as _,X as T,h as j,t as h,j as F,Y as ye}from"./main-DHXZBRQ4.js";import{d as Ve}from"./debounce-DFd21Ooa.js";import{V as X,b as ke,a as G}from"./VCard--A0TG-0k.js";import{V as xe,a as Y}from"./VTable-BFBWHWKR.js";import{V as be}from"./VPagination-DYSV3PuI.js";import{m as Ce,V as q}from"./VSelectionControl-U3dUhfvP.js";import{V as Ie}from"./VDialog-BrfHzCJR.js";import"./VAvatar-77KL_Eez.js";import"./VImg-DDxq5_W8.js";const Se=le({indeterminate:Boolean,inset:Boolean,flat:Boolean,loading:{type:[Boolean,String],default:!1},...ne(),...Ce()},"VSwitch"),Pe=re()({name:"VSwitch",inheritAttrs:!1,props:Se(),emits:{"update:focused":a=>!0,"update:modelValue":a=>!0,"update:indeterminate":a=>!0},setup(a,g){let{attrs:N,slots:l}=g;const y=O(a,"indeterminate"),c=O(a,"modelValue"),{loaderClasses:I}=ie(a),{isFocused:D,focus:B,blur:R}=ce(a),v=x(),r=de&&window.matchMedia("(forced-colors: active)").matches,d=W(()=>typeof a.loading=="string"&&a.loading!==""?a.loading:a.color),m=ue(),s=W(()=>a.id||`switch-${m}`);function o(){y.value&&(y.value=!1)}function f(i){var k,u;i.stopPropagation(),i.preventDefault(),(u=(k=v.value)==null?void 0:k.input)==null||u.click()}return he(()=>{const[i,k]=me(N),u=K.filterProps(a),J=q.filterProps(a);return t(K,$({class:["v-switch",{"v-switch--flat":a.flat},{"v-switch--inset":a.inset},{"v-switch--indeterminate":y.value},I.value,a.class]},i,u,{modelValue:c.value,"onUpdate:modelValue":A=>c.value=A,id:s.value,focused:D.value,style:a.style}),{...l,default:A=>{let{id:Z,messagesId:ee,isDisabled:te,isReadonly:ae,isValid:H}=A;const M={model:c,isValid:H};return t(q,$({ref:v},J,{modelValue:c.value,"onUpdate:modelValue":[S=>c.value=S,o],id:Z.value,"aria-describedby":ee.value,type:"checkbox","aria-checked":y.value?"mixed":void 0,disabled:te.value,readonly:ae.value,onFocus:B,onBlur:R},k),{...l,default:S=>{let{backgroundColorClasses:U,backgroundColorStyles:V}=S;return t("div",{class:["v-switch__track",r?void 0:U.value],style:V.value,onClick:f},[l["track-true"]&&t("div",{key:"prepend",class:"v-switch__track-true"},[l["track-true"](M)]),l["track-false"]&&t("div",{key:"append",class:"v-switch__track-false"},[l["track-false"](M)])])},input:S=>{let{inputNode:U,icon:V,backgroundColorClasses:se,backgroundColorStyles:oe}=S;return t(b,null,[U,t("div",{class:["v-switch__thumb",{"v-switch__thumb--filled":V||a.loading},a.inset||r?void 0:se.value],style:a.inset?void 0:oe.value},[l.thumb?t(fe,{defaults:{VIcon:{icon:V,size:"x-small"}}},{default:()=>[l.thumb({...M,icon:V})]}):t(pe,null,{default:()=>[a.loading?t(_e,{name:"v-switch",active:!0,color:H.value===!1?void 0:d.value},{default:z=>l.loader?l.loader(z):t(ve,{active:z.isActive,color:z.color,indeterminate:!0,size:"16",width:"2"},null)}):V&&t(C,{key:String(V),icon:V,size:"x-small"},null)]})])])}})}})}),{}}}),Fe={class:"d-flex justify-between align-center"},Ne=e("div",{class:"w-100"},[e("h4",null,"Tutor/Mentor")],-1),Te={class:"w-25"},De=e("thead",null,[e("tr",null,[e("th",{class:"text-uppercase",width:"1%"}," No "),e("th",{class:"text-uppercase text-center"},"Mentor/Tutor Name"),e("th",{class:"text-uppercase text-center"},"Email"),e("th",{class:"text-uppercase text-center"},"Role"),e("th",{nowrap:""},"Inhouse Mentor"),e("th",{class:"text-uppercase text-center"},"Phone Number"),e("th",{class:"text-uppercase text-center"},"Detail")])],-1),Be={nowrap:""},Re={class:"text-start",nowrap:""},Ae={class:"text-start",nowrap:""},Me={key:0},Ue={class:"d-flex justify-center"},ze={class:"text-start",nowrap:""},Ee={class:"text-center",nowrap:""},Le={class:"d-flex justify-between align-center mb-3"},je=e("h4",{class:"w-100"},"Detail",-1),Ge=e("thead",null,[e("tr",null,[e("th",{class:"text-left",nowrap:""}," Subject Tutoring "),e("th",{nowrap:""},"Grade"),e("th",{nowrap:""},"Head"),e("th",{nowrap:""},"Fee Individual"),e("th",{nowrap:""},"Fee Group"),e("th",{nowrap:"",class:"text-end"}," Additional Fee ")])],-1),$e={nowrap:""},He={nowrap:""},Oe={nowrap:""},We={nowrap:""},Ke={nowrap:""},Qe={class:"text-end",nowrap:""},Xe={key:0},Ye=e("tr",null,[e("td",{colspan:"6",class:"text-center"}," Sorry, no data found. ")],-1),qe=[Ye],Je={class:"d-flex justify-center mt-5"},it={__name:"tutor",setup(a){const g=x(1),N=x(),l=x(),y=x([]),c=x(!1),I=async()=>{var m,s;const v="?page="+g.value,r=l.value?"&keyword="+l.value:"",d="&paginate=true";try{c.value=!0;const o=await E.get("api/v1/user/mentor-tutors"+v+r+d);o&&(g.value=o.current_page,N.value=o.last_page,y.value=o),c.value=!1}catch(o){L("error",(s=(m=o.response)==null?void 0:m.data)==null?void 0:s.message,"bottom-end"),console.error(o),c.value=!1}},D=Ve(async()=>{g.value=1,await I()},1e3),B=async v=>{try{const r=await E.post("api/v1/auth/email/checking",{email:v})}catch(r){console.error(r)}},R=async(v,r,d)=>{var m,s;await B(d);try{const o=await E.put("api/v1/user/mentor-tutors/"+v,{inhouse:r?1:0});o&&L("success",o.message,"bottom-end")}catch(o){console.error(o),L("error",(s=(m=o.response)==null?void 0:m.data)==null?void 0:s.errors,"bottom-end")}};return we(()=>{I()}),(v,r)=>(n(),P(X,null,{default:p(()=>[t(ke,null,{default:p(()=>[e("div",Fe,[Ne,e("div",Te,[t(ge,{modelValue:w(l),"onUpdate:modelValue":r[0]||(r[0]=d=>Q(l)?l.value=d:null),loading:w(c),disabled:w(c),"append-inner-icon":"ri-search-line",density:"compact",label:"Search",variant:"solo","hide-details":"","single-line":"",onInput:w(D)},null,8,["modelValue","loading","disabled","onInput"])])])]),_:1}),t(G,null,{default:p(()=>[w(c)?(n(),P(xe,{key:0,class:"mx-auto border",type:"table-thead, table-row@10"})):(n(),P(Y,{key:1},{default:p(()=>{var d,m;return[De,e("tbody",null,[(n(!0),_(b,null,T(w(y).data,(s,o)=>(n(),_("tr",{key:o},[e("td",null,h(parseInt(o)+1),1),e("td",Be,[t(C,{icon:"ri-user-line",class:"me-3"}),F(" "+h(s.full_name),1)]),e("td",Re,[t(C,{icon:"ri-mail-line",class:"me-3"}),F(" "+h(s.email),1)]),e("td",Ae,[t(C,{icon:"ri-user-line",class:"me-3"}),(n(!0),_(b,null,T(s.roles,(f,i)=>(n(),_("span",{key:i},[F(h(f.name)+" ",1),i<s.roles.length-1?(n(),_("span",Me,", ")):j("",!0)]))),128))]),e("td",Ue,[t(Pe,{modelValue:s.inhouse,"onUpdate:modelValue":[f=>s.inhouse=f,f=>R(s.uuid,s.inhouse,s.email)],value:"1"},null,8,["modelValue","onUpdate:modelValue"])]),e("td",ze,[t(C,{icon:"ri-smartphone-line",class:"me-3"}),F(" "+h(s.phone),1)]),e("td",Ee,[t(Ie,{"max-width":"600"},{activator:p(({props:f})=>[t(C,$({icon:"ri-folder-info-line",class:"cursor-pointer",ref_for:!0},f),null,16)]),default:p(({isActive:f})=>[t(X,null,{default:p(()=>[t(G,{class:"py-5"},{default:p(()=>[e("div",Le,[je,t(ye,{size:"x-small",color:"secondary",icon:"ri-close-line",onClick:i=>f.value=!1},null,8,["onClick"])]),s.roles.findIndex(i=>i.name==="Tutor")>=0?(n(),P(Y,{key:0,density:"compact"},{default:p(()=>[Ge,e("tbody",null,[(n(!0),_(b,null,T(s.roles,(i,k)=>(n(),_(b,{key:k},[i.name=="Tutor"?(n(!0),_(b,{key:0},T(i.subjects,u=>(n(),_("tr",{key:u},[e("td",$e,h(u.tutor_subject),1),e("td",He,h(u.grade),1),e("td",Oe,h(u.head),1),e("td",We,"Rp. "+h(new Intl.NumberFormat("id-ID").format(u.fee_individual)),1),e("td",Ke,"Rp. "+h(new Intl.NumberFormat("id-ID").format(u.fee_group)),1),e("td",Qe," Rp. "+h(new Intl.NumberFormat("id-ID").format(u.additional_fee)),1)]))),128)):j("",!0)],64))),128))])]),_:2},1024)):(n(),P(G,{key:1,class:"text-center"},{default:p(()=>[F(" There is no tutoring subject ")]),_:1}))]),_:2},1024)]),_:2},1024)]),_:2},1024)])]))),128))]),((m=(d=w(y))==null?void 0:d.data)==null?void 0:m.length)==0?(n(),_("tfoot",Xe,qe)):j("",!0)]}),_:1})),e("div",Je,[t(be,{modelValue:w(g),"onUpdate:modelValue":[r[1]||(r[1]=d=>Q(g)?g.value=d:null),I],length:w(N),"total-visible":5,color:"primary",density:"compact","show-first-last-page":!1},null,8,["modelValue","length"])])]),_:1})]),_:1}))}};export{it as default};
