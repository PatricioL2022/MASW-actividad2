import { ComponentFixture, TestBed } from '@angular/core/testing';

import { CitaagendamedicoComponent } from './citaagendamedico.component';

describe('CitaagendamedicoComponent', () => {
  let component: CitaagendamedicoComponent;
  let fixture: ComponentFixture<CitaagendamedicoComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      imports: [CitaagendamedicoComponent]
    })
    .compileComponents();

    fixture = TestBed.createComponent(CitaagendamedicoComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
