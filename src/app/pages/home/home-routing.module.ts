import { NgModule } from '@angular/core';
import { Routes, RouterModule } from '@angular/router';

import { HomePage } from './home.page';

const routes: Routes = [
  {
    //defect path
    path: '',
    redirectTo: '/home/information',
    pathMatch: 'full'
  },
  {
    path: '',
    component: HomePage,
    children: [
      {
        path: 'information',
        loadChildren: () => import('../information/information.module').then( m => m.InformationPageModule )
      },
      {
        path: 'profile',
        loadChildren: () => import('../profile/profile.module').then( m => m.ProfilePageModule )
      },
      {
        path: 'chat-home',
        loadChildren: () => import('../chat-home/chat-home.module').then( m => m.ChatHomePageModule )
      },
      {
        path: 'file',
        loadChildren: () => import('../file/file.module').then( m => m.FilePageModule )
      },
      {
        path: 'documents',
        loadChildren: () => import('../documents/documents.module').then( m => m.DocumentsPageModule )
      }
    ]
  }
];

@NgModule({
  imports: [RouterModule.forChild(routes)],
  exports: [RouterModule],
})
export class HomePageRoutingModule {}
