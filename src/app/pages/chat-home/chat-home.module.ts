import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { FormsModule } from '@angular/forms';

import { IonicModule } from '@ionic/angular';

import { ChatHomePageRoutingModule } from './chat-home-routing.module';

import { ChatHomePage } from './chat-home.page';
import { ComponentsModule } from '../../components/components.module';

@NgModule({
  imports: [
    CommonModule,
    FormsModule,
    IonicModule,
    ChatHomePageRoutingModule,
    ComponentsModule
  ],
  declarations: [ChatHomePage]
})
export class ChatHomePageModule {}
