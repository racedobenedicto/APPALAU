import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { HeaderComponent } from './header/header.component';
import { FooterComponent } from './footer/footer.component';
import { InfosComponent } from './infos/infos.component';
import { InfoComponent } from './info/info.component';
import { AbsencesComponent } from './absences/absences.component';
import { IncidentsComponent } from './incidents/incidents.component';
import { CommentsComponent } from './comments/comments.component';
import { JustifyComponent } from './justify/justify.component';
import { PersonalDataComponent } from './personal-data/personal-data.component';
import { GroupDataComponent } from './group-data/group-data.component';
import { ContactDataComponent } from './contact-data/contact-data.component';
import { FormsModule } from '@angular/forms';
import {IonicModule} from '@ionic/angular';
import { MessageComponent } from './message/message.component';
import { HeaderLoginComponent } from './header-login/header-login.component';
import { HeaderEditComponent } from './header-edit/header-edit.component';
import { MsgComponent } from './msg/msg.component';



@NgModule({
  declarations: [
    HeaderComponent,
    FooterComponent,
    InfosComponent,
    InfoComponent,
    AbsencesComponent,
    IncidentsComponent,
    CommentsComponent,
    JustifyComponent,
    PersonalDataComponent,
    GroupDataComponent,
    ContactDataComponent,
    MessageComponent,
    HeaderLoginComponent,
    HeaderEditComponent,
    MsgComponent
  ],
  exports: [
    HeaderComponent,
    FooterComponent,
    InfosComponent,
    InfoComponent,
    AbsencesComponent,
    IncidentsComponent,
    CommentsComponent,
    JustifyComponent,
    PersonalDataComponent,
    GroupDataComponent,
    ContactDataComponent,
    MessageComponent,
    HeaderLoginComponent,
    HeaderEditComponent,
    MsgComponent
  ],
  imports: [
    CommonModule,
    IonicModule,
    FormsModule
  ]
})
export class ComponentsModule { }
