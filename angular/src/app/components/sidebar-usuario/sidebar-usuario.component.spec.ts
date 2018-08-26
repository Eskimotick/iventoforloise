import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { SidebarUsuarioComponent } from './sidebar-usuario.component';

describe('SidebarUsuarioComponent', () => {
  let component: SidebarUsuarioComponent;
  let fixture: ComponentFixture<SidebarUsuarioComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ SidebarUsuarioComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(SidebarUsuarioComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
